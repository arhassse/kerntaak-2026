# Saarr's Modesty - Webshop

## Over het project
Dit is een PHP MVC webshop ontwikkeld voor Kerntaak K1W3.

## Functionaliteiten
- MVC structuur
- Routing systeem
- Categorieën en producten
- Winkelwagen (session-based)
- Checkout met order opslag
- Voorraadbeheer
- Login systeem met password_hash
- Admin dashboard

## Technieken
- PHP 8
- PDO (prepared statements)
- MySQL
- Bootstrap 5
- Git versiebeheer

## Security
- Prepared statements tegen SQL-injection
- CSRF tokens
- Password hashing (password_hash + password_verify)
- Role-based access (admin)

## Installatie
1. Clone repo
2. Importeer schema.sql + seed.sql
3. Zet project in htdocs
4. Ga naar /public


## Inloggen als admin
Gebruik een account uit de database (zie seed of phpMyAdmin).