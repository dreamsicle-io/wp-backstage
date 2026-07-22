#!/bin/bash

# This file must have permissions to run in a GitHub action.
# To do this cross-env, use the following command from the project root:
# git update-index --chmod=+x .github/workflows/scripts/env.sh

# Get PHP version that satisfies the setup-php action version keys
# by parsing the composer.json file's require.php config.

RAW_PHP_VERSION=$(jq -r ".require.php" composer.json)
MAJOR_VERSION_PATTERN="^\^"
PHP_VERSION=""
if [[ $RAW_PHP_VERSION =~ $MAJOR_VERSION_PATTERN ]]; then
	PHP_VERSION=$(echo $RAW_PHP_VERSION | grep -oE "[0-9]+" | head -n 1)
else
	PHP_VERSION=$(echo $RAW_PHP_VERSION | grep -oE "[0-9]+(\.[0-9]+)?" | head -n 1)
fi

# Get the theme version from the plugin file.

PLUGIN_VERSION=$(sed -nE 's/^[[:space:]]*\*[[:space:]]*Version:[[:space:]]*(.+)[[:space:]]*$/\1/p' wp-backstage.php | head -n 1)

# Set environment variables on $GITHUB_ENV.

echo "PHP_VERSION=$(echo $PHP_VERSION)" >> $GITHUB_ENV
echo "PLUGIN_VERSION=$(echo $PLUGIN_VERSION)" >> $GITHUB_ENV
