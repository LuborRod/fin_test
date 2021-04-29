up:env-init \
	migrate-up \
	fill-test-data

down:
	 ./vendor/bin/sail down

env-init:
	./vendor/bin/sail up -d

migrate-up:
	./vendor/bin/sail artisan migrate

fill-test-data:
	./vendor/bin/sail artisan fill:testData

tests:
	./vendor/bin/sail TTTTTTTTTTTTTEEEEEEEEEEEEESSSSSSSSSSSSTTTTTTTTTTT
