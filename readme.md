# Laravel 5.6 based system for landlords/tenants to manage properties

It is a demo project for [live-coding session on YouTube](https://www.youtube.com/watch?v=64kS5mrZUwU&list=PLdXLsjL7A9k2-8Gg4oEmFhxPEXleduoSF).

Partly demonstrating what can be generated with [QuickAdminPanel](https://quickadminpanel.com) tool.

![Landlords_tenants screenshot](http://webcoderpro.com/landlords-tenants.png)

## How to use

- Clone the repository with __git clone__
- Copy __.env.example__ file to __.env__ and edit database/Stripe credentials there
- Run __composer install__
- Run __php artisan key:generate__
- Run __php artisan migrate --seed__ (it has some seeded data for your testing)
- That's it: launch the main URL and login with default credentials __admin@admin.com__ - __password__

## License

Basically, feel free to use and re-use any way you want.