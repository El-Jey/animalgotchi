.PHONY:

deploy: up install-packages
artisankey: .PHONY
	docker-compose exec app php artisan key:generate
destroy: .PHONY
	docker-compose -f docker-compose.yml down -v
dev: .PHONY
	npm run watch
down: .PHONY
	docker-compose -f docker-compose.yml down
install-packages: .PHONY
	docker-compose -f docker-compose.yml exec app npm install
	docker-compose -f docker-compose.yml exec app composer install
logs: .PHONY
	docker-compose -f docker-compose.yml logs --tail=100 -f
prod: .PHONY
	npm run prod
restart: .PHONY
	docker-compose -f docker-compose.yml restart
start: .PHONY
	docker-compose -f docker-compose.yml start
stop: .PHONY
	docker-compose -f docker-compose.yml stop
up: .PHONY
	docker-compose -f docker-compose.yml up -d