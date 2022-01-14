CMD=cd laradock && docker compose
run-up:
	$(CMD) up -d nginx mysql phpmyadmin workspace
run-composer-install:
	$(CMD) exec workspace composer install
run-migrate:
	$(CMD) exec workspace php artisan migrate
run-fill-codes:
	$(CMD) exec workspace php artisan save:codes
run-fill-rates:
	$(CMD) exec workspace php artisan save:rates
run-shell:
	$(CMD) exec workspace bash
