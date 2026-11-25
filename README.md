# WordPress Core — tichetul #66802

Contribuție pentru **WordPress Credits**. Am verificat cum tratează `diff.php` fișierele de rezultate incomplete și am publicat un review cu o propunere de clarificare a documentației.

- [Tichetul #66802 în WordPress Core Trac](https://core.trac.wordpress.org/ticket/66802)
- [Pull request-ul #16204 în WordPress Core](https://github.com/WordPress/wordpress-develop/pull/16204)
- [Review-ul publicat de `andreivrabielucian-dev`](https://github.com/WordPress/wordpress-develop/pull/16204#pullrequestreview-6041092705)

## Reproducere locală

Rulează comenzile din rădăcina acestui repo. Ai nevoie de PHP CLI și `curl`. Verificarea a fost rulată cu PHP 8.1.

```sh
curl -fsSL https://raw.githubusercontent.com/WordPress/wordpress-develop/363c9fb4439f28c8f622812bcc53c8bbd2ecd920/tests/phpunit/leaks/diff.php -o /tmp/wp-66802-diff.php
php main.php /tmp/wp-66802-diff.php
```

[`main.php`](main.php) creează două fișiere JSONL temporare, fiecare cu un singur instantaneu `class_start` al aceleiași clase. Scriptul rulează ambele moduri din versiunea indicată a PR-ului, verifică rezultatele și elimină fișierele de probă.

| Mod | Rezultat observat |
| --- | --- |
| Compararea a două rulări | Diferența `global\|example` a fost raportată. Cod de ieșire `2`. |
| Analiza unei singure rulări | Fișierul a fost raportat ca `Incomplete run`. Cod de ieșire `1`. |

În review am propus ca documentația să specifice că modul de comparație acceptă instantanee parțiale și nu verifică dacă rulările s-au încheiat.

Codex a asistat la analiza codului, la verificarea locală și la redactarea review-ului.
