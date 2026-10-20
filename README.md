# done-list-app

Webapp for tracking finished work

## Umsetzungs Eckpunkte, Reihenfolge

1. 15.10: Planung in README und OneNote
    1. Datenmodell, neue Einträge, Export
    2. Seiten und Dateien, Login
2. Feedback von Kim einholen
3. Woche 43: Umsetzung
    1. Seite ist im Browser erreichbar
    4. Datenbank verbindung funktioniert
    5. Einträge können erfasst, bearbeitet und angezeigt werden
    6. Login, Passwort Hash
    7. CSRF Tokens
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