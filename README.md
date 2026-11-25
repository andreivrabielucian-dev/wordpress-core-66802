# Organizator pentru facultate

Aplicație de consolă în C pentru gestionarea sarcinilor de facultate. Codul sursă este în [`main.c`](main.c).

## Funcționalități

- Adăugarea și afișarea sarcinilor.
- Marcarea unei sarcini ca terminată sau redeschiderea ei.
- Ștergerea unei sarcini după numărul din listă.
- Afișarea numărului de sarcini terminate.
- Salvarea automată în `sarcini.txt` după fiecare modificare.
- Validarea opțiunilor, a descrierilor și a fișierului încărcat.

## Rulare în OnlineGDB

1. Deschide https://www.onlinegdb.com/ și selectează limbajul **C**.
2. Copiază conținutul din `main.c` în editor.
3. Selectează **Interactive Console** pentru introducerea datelor, apoi apasă **Run**.
4. Introdu opțiunile și descrierile în consolă. Apasă Enter după fiecare răspuns.

Programul creează `sarcini.txt` în mediul în care rulează. Păstrarea fișierului între sesiuni depinde de mediul OnlineGDB. Descarcă fișierul separat dacă vrei să păstrezi sarcinile. Nu publica sarcini personale pe GitHub.

## Rulare locală

Din directorul proiectului, compilează și rulează programul cu un compilator C precum GCC.

```sh
gcc -std=c11 -Wall -Wextra -Wpedantic main.c -o organizator
./organizator
```

## Exemplu

```text
1. [ ] Termin exercitiile la programare
2. [X] Recapitulez cursul de retele
Progres: 1 din 2 terminate.
```

## Structură și limite

`Sarcina` grupează descrierea și starea unei activități. Programul folosește un tablou cu maximum 100 de sarcini. Fiecare descriere poate ocupa cel mult 159 de octeți. Diacriticele pot ocupa mai mulți octeți, iar numerele din listă se schimbă după ștergere.

Fișierul conține câte două rânduri pentru fiecare sarcină. Primul conține starea (`0` sau `1`), al doilea descrierea. Programul acceptă rânduri cu terminatori LF și CRLF. La salvare, scrie mai întâi într-un fișier temporar și înlocuiește lista veche după ce scrierea reușește. Programul se oprește dacă fișierul existent nu poate fi citit sau are format invalid.

## Context

Proiect de început, pregătit cu asistență AI pentru studiu și dezvoltare treptată. Codul inițial folosește structuri, tablouri, funcții și fișiere. Următorul pas este înțelegerea și modificarea fiecărei părți.

## Idei pentru versiuni viitoare

- Materie și termen-limită pentru fiecare sarcină.
- Filtrarea sarcinilor neterminate.
- Căutare după cuvinte.
