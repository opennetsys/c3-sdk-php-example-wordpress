all:
	@echo "no default"

.PHONY: build
build:
	@docker-compose up

.PHONY: run
run:
	@docker-compose up

.PHONY: ssh/wp
ssh/wp:
	@docker exec -it $(CONTAINER) /bin/bash

.PHONY: ssh/db
ssh/db:
	@docker exec -it e2b83e16e36e /bin/bash

.PHONY: test/payload
test/payload:
	@echo '["createPost"]' |  nc localhost 3330

# requires plugin
# https://github.com/WP-API/Basic-Auth
