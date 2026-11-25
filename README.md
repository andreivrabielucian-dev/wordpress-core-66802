# WordPress Core ticket #66802

WordPress Credits contribution documenting a reproducible check and a published review of the proposed PHPUnit state-leak detection tool.

- [WordPress Core Trac ticket #66802](https://core.trac.wordpress.org/ticket/66802)
- [WordPress Core pull request #16204](https://github.com/WordPress/wordpress-develop/pull/16204)
- [Published review by `andreivrabielucian-dev`](https://github.com/WordPress/wordpress-develop/pull/16204#pullrequestreview-6041092705)

## Reproduce the check

Run these commands from the repository root with PHP CLI and `curl`. The check was verified with PHP 8.1.

```sh
upstream_script=$(mktemp)
curl -fsSL https://raw.githubusercontent.com/WordPress/wordpress-develop/363c9fb4439f28c8f622812bcc53c8bbd2ecd920/tests/phpunit/leaks/diff.php -o "$upstream_script" &&
  php main.php "$upstream_script"
rm -f "$upstream_script"
```

[`main.php`](main.php) creates two temporary JSONL files containing one `class_start` snapshot each, runs both modes of the pinned upstream `diff.php`, and checks the results.

| Command mode | Observed result |
| --- | --- |
| Two-run comparison | Reported the `global\|example` difference and exited with code `2`. |
| Single-run analysis | Reported `Incomplete run` and exited with code `1`. |

The review asks the maintainers to document that comparison mode accepts partial snapshots without checking whether either run completed.

Codex assisted with code analysis, local verification, and drafting the review.
