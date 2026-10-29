# done-list-app

Webapp for tracking finished work

## Setup

1. PHP Installieren: `apt-get install php-cli && apt install php-sqlite3`
2. Branch Register-User holen: `git clone -b Register-User https://github.com/AaronGEWA/done-list-app.git`
3. PHP built-in Webserver starten: `php -S <ip:port>`
4. Auf der Webseite Username und Passwort registrieren
5. Zum Branch main wechseln: `git checkout main`

## Umsetzungs Eckpunkte, Reihenfolge

1. 15.10: Planung in README und OneNote
    1. Datenmodell, neue Einträge, Export
    2. Seiten und Dateien, Login
2. Feedback von Kim einholen
3. Woche 43: Umsetzung
    1. Seite ist im Browser erreichbar
    2. Datenbank verbindung funktioniert
    3. Einträge können erfasst, bearbeitet und angezeigt werden
    4. *Einträge können exportiert werden*
    5. Login, Passwort Hash
    6. CSRF Tokens
4. Woche 44: Angriff
    1. Mögliche Angriffsmuster finden
    2. Angriffs Scripts schreiben
    3. Ergebnisse festhalten 

## Einträge

Abgeschlossene Einträge besitzen folgende Felder (Erlaubte Eintragsform in Klammern):
- ID (Zahl, aufsteigend)
- Titel (Text, höchstens 64 Zeichen)
- Beschreibung (Text, höchstens 512 Zeichen)
- Abschlussdatum (Datum: YYYY-MM-DD, leer wenn nicht abgeschlossen)
- Status (completed|cancelled)