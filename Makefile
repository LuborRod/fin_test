up:
	env-init
	migrate-up

env-init:
	./vendor/bin/sail up -d

migrate-up:
	./vendor/bin/sail artisan migrate

tests:
	./vendor/bin/sail TTTTTTTTTTTTTEEEEEEEEEEEEESSSSSSSSSSSSTTTTTTTTTTT
