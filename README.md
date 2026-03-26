# Bibliotēkas pasākumu uzskaite

Šis projekts ir Laravel lietotne bibliotēkas pasākumu, telpu, lietotāju un jaunumu pārvaldībai.

## Galvenās iespējas

- Pasākumu izveide, rediģēšana un dzēšana.
- Telpu pārvaldība ar ietilpības norādi.
- Atbildīgo darbinieku piešķiršana pasākumiem.
- Telpu un darbinieku pieejamības pārbaude izvēlētajā laika periodā.
- Jaunumu publicēšana ar attēliem.
- Lietotāju reģistrācija un profilu apstiprināšana.
- Pieteikšanās pasākumiem un atsauksmju saglabāšana.

## Izmantotās tehnoloģijas

- PHP un Laravel
- Blade veidnes
- MySQL vai cita Laravel atbalstīta datubāze
- Vite frontenda resursu būvēšanai

## Palaišana lokāli

1. Instalējiet PHP atkarības ar `composer install`.
2. Instalējiet frontenda atkarības ar `npm install`.
3. Izveidojiet `.env` failu un norādiet datubāzes iestatījumus.
4. Ģenerējiet lietotnes atslēgu ar `php artisan key:generate`.
5. Izpildiet migrācijas ar `php artisan migrate`.
6. Palaidiet izstrādes serveri ar `php artisan serve`.

## Piezīmes

- Projekta saskarne un validācijas ziņojumi ir pielāgoti latviešu valodai.
- Trešo pušu bibliotēku faili `vendor` mapē nav tulkoti, jo tie pieder ārējām atkarībām.
