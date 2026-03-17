<?php
/**
 * Bump the plugin version in the WordPress release metadata files.
 *
 * Usage:
 * - composer run version patch
 * - composer run version minor
 * - composer run version major
 * - composer run version 4.1.0
 */

/* phpcs:disable WordPress */

$root = dirname( __DIR__ );

// These two files are the release-facing version sources for the plugin.
$targets = array(
	array(
		'label'   => 'plugin header',
		'path'    => $root . '/wp-backstage.php',
		'pattern' => '/^(\s*\*\s+Version:\s*)(\d+\.\d+\.\d+)\s*$/m',
	),
	array(
		'label'   => 'readme stable tag',
		'path'    => $root . '/readme.txt',
		'pattern' => '/^(Stable tag:\s*)(\d+\.\d+\.\d+)\s*$/m',
	),
);

$input = $argv[1] ?? '';

if ( '' === $input ) {
	fwrite(
		STDERR,
		"Usage: composer run version [major|minor|patch|x.y.z]\n"
	);
	exit( 1 );
}

$current_versions = array();

foreach ( $targets as $target ) {
	$contents = file_get_contents( $target['path'] );

	if ( false === $contents ) {
		fwrite( STDERR, "Unable to read {$target['path']}\n" );
		exit( 1 );
	}

	if ( 1 !== preg_match( $target['pattern'], $contents, $matches ) ) {
		fwrite( STDERR, "Unable to find version in {$target['path']}\n" );
		exit( 1 );
	}

	$current_versions[] = $matches[2];
}

$current_versions = array_values( array_unique( $current_versions ) );

// Refuse to bump if the tracked release files have already drifted apart.
if ( 1 !== count( $current_versions ) ) {
	fwrite( STDERR, "Version mismatch between release files.\n" );
	exit( 1 );
}

$current_version = $current_versions[0];
$next_version    = $input;

// Support npm-style bump keywords as shorthand for an explicit semver.
if ( in_array( $input, array( 'major', 'minor', 'patch' ), true ) ) {
	$segments = array_map( 'intval', explode( '.', $current_version ) );

	switch ( $input ) {
		case 'major':
			++$segments[0];
			$segments[1] = 0;
			$segments[2] = 0;
			break;

		case 'minor':
			++$segments[1];
			$segments[2] = 0;
			break;

		case 'patch':
			++$segments[2];
			break;
	}

	$next_version = implode( '.', $segments );
}

if ( 1 !== preg_match( '/^\d+\.\d+\.\d+$/', $next_version ) ) {
	fwrite( STDERR, "Invalid version \"{$input}\". Use major, minor, patch, or x.y.z.\n" );
	exit( 1 );
}

if ( $current_version === $next_version ) {
	fwrite( STDOUT, "Version unchanged: {$current_version}\n" );
	exit( 0 );
}

// Apply the resolved version to each release metadata file in one pass.
foreach ( $targets as $target ) {
	$contents = file_get_contents( $target['path'] );

	if ( false === $contents ) {
		fwrite( STDERR, "Unable to read {$target['path']}\n" );
		exit( 1 );
	}

	$updated = preg_replace( $target['pattern'], '${1}' . $next_version, $contents, 1, $count );

	if ( null === $updated || 1 !== $count ) {
		fwrite( STDERR, "Unable to update {$target['path']}\n" );
		exit( 1 );
	}

	if ( false === file_put_contents( $target['path'], $updated ) ) {
		fwrite( STDERR, "Unable to write {$target['path']}\n" );
		exit( 1 );
	}
}

fwrite( STDOUT, "Updated version {$current_version} -> {$next_version}\n" );
