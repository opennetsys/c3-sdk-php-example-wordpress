all:
	@echo "no default"

.PHONY: build
build:
	@docker build -t demo .

.PHONY: run
run:
	docker run -p 8080:8080 -p 3330:3330 demo:latest

.PHONY: ssh
ssh:
	@docker exec -it $(CONTAINER) /bin/bash

.PHONY: ssh/last
ssh/last:
	@make ssh CONTAINER=$$(docker ps -q -l)

.PHONY: payload
payload:
	@echo '["createPost", "hello world", "my content"]' |  nc localhost 3330

# requires plugin
# https://github.com/WP-API/Basic-Auth
