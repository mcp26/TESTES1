# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Status
This project is in initial setup. Update this file as the project structure is defined.

## GitHub Repository
- Remote: https://github.com/mcp26/TESTES1
- Branch: `master`
- Auto-push is active: every file saved via Claude Code is automatically committed and pushed to GitHub.

## Auto-Sync Behavior
A `PostToolUse` hook in `.claude/settings.json` runs after every `Write` or `Edit` tool call:
1. Stages all changes (`git add -A`)
2. Commits with message `"Auto-update via Claude Code"` (only if there are staged changes)
3. Pushes to `origin/master`

To disable auto-push temporarily, remove or comment out the hook in `.claude/settings.json`.

## Commands
_To be added once the project type and tooling are defined._

## Architecture
_To be added once the project structure is established._
