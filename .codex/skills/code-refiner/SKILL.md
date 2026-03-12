---
name: code-refiner
description: Perform a code-quality, verbosity, and refinement pass on generated or recently edited code in the codebase so naming, organization, and style match local conventions. Use when code is functionally correct but inconsistent with repository patterns, is overly verbose, or is difficult for a human engineer familiar with this codebase to reason through and read. Run when preparing commit-ready changes, when asked to polish/cleanup/align code style, or when the developer is expressing concerns about the updated code.
---

# Code Refiner

Refine working code into repository-native code. Treat form as equally important to function.

## Purpose

Perform a code-quality, verbosity, and refinement pass to form the code into the style this repo expects. Detect nuanced anomales in naming conventions, code style, organization, and other patterns to refine contributions and improve readability.

## Understanding

Understand why generated and written code drifts from patterns and use actionable insights to make concrete changes, finalizing code into a shape that the developers of this project will not only like, **they will love**. Read adjacent files, understand file structure, and detect differences. Shape the code into a final, committable shape.

Understand the full context of the application and similar files, and why code looks the way it does. Consider these nuances **as important** as the functionality of the code. Treat _form_ as an essential partner of _function_.

Understand when abstraction should happen, and when it is unnecessary (even if viable).

## Signals

Consult the code editor configuration, lint and build tooling configuration, and most importantly - **style of existing code**.

- Consult adjacent siblings in the same feature family
	- When refining field classes, consult the other field classes and their methods.
	- When refining component classes, consult the other component classes and their methods.
- Consult the `README.md` and `AGENTS.md` files.
- Consult package configuration, like `composer.json`.
- Consult PHPCS configuration in `phpcs.xml`.
- Consult editor configuration in `.vscode/settings.json`.
- Consult usage of public APIs in `examples/tests.php`

## Refinement Workflow

1. Read appropriate signals.
	- See `## Signals` section.
2. Detect and resolve pattern drift.
  - Normalize constant names, variable names, and function names to local conventions.
  - Normalize `if/else` branches to local conventions.
  - Normalize guards and early return patterns.
3. Preserve behavior while improving shape.
  - Keep public APIs backward compatible unless asked to change them.
  - Prefer focused refactors over broad rewrites.
  - Keep edits scoped to the requested area and directly related code.
  - Collapse methods to the smallest readable control flow.
  - Remove redundant guards already enforced upstream.
4. Verify and close with objective checks.
  - Run relevant lint checks.
  - Ensure code reads as if authored by the same team.

## Output Standard

Declare work complete only when the code:

- Is functionally correct.
- Is stylistically and structurally indistinguishable from surrounding repository code.
- Feels written by the same developers as the rest of the application

If uncertain between two valid implementations, choose the option that best matches adjacent files and existing conventions.
