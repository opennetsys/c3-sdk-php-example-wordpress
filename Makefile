BIN = go run $$GOPATH/src/github.com/c3systems/c3-go/main.go
WP_PORT = 8000

all:
	@echo "no default"

.PHONY: build
build:
	@docker build -t demo .

.PHONY: build/nocache
build/nocache:
	@docker build --no-cache -t demo .

.PHONY: run
run:
	docker run -p $(WP_PORT):$(WP_PORT) -p 3333:3333 demo:latest

CONTAINER = "$$(docker ps --last 0 -q)"

.PHONY: ssh
ssh:
	@docker exec -it $(CONTAINER) /bin/bash

.PHONY: ssh/last
ssh/last:
	@make ssh CONTAINER=$$(docker ps -q -l)

TITLE = Hello World
CONTENT = This is my first post

.PHONY: payload/create
payload/create:
	@echo '["createPost", "$(TITLE)", "$(CONTENT)"]' |  nc localhost 3333

.PHONY: payload/delete
payload/delete:
	@echo '["deletePost", "5"]' |  nc localhost 3333

.PHONY: payload/refresh
payload/refresh:
	@echo '["refresh"]' |  nc localhost 3333

.PHONY: key
key:
	@$(BIN) generate key

PEER := "/ip4/127.0.0.1/tcp/3330/ipfs/QmZPNaCnnR59Dtw5nUuxv33pNXxRqKurnZTHLNJ6LaqEnx"

IMAGE := "e2289d0f442c"

.PHONY: deploy
deploy:
	@$(BIN) deploy --priv priv.pem --genesis '' --image $(IMAGE) --peer $(PEER)

.PHONY: tx
tx:
	@$(BIN) invokeMethod --payload '["createPost", "$(TITLE)", "$(CONTENT)"]' --priv priv.pem --image $(IMAGE) --peer $(PEER)

.PHONY: run/snapshot
run/snapshot:
	@kill $$(lsof -t -i:$(WP_PORT)); docker run --rm -v $$(pwd)/start.sh:/start.sh -p $(WP_PORT):$(WP_PORT) $(IMAGE) /start.sh

.PHONY: watch
watch:
	@IMAGE=$(IMAGE) CONTAINER=$(CONTAINER); ./watch.sh

.PHONY: docker/killall
docker/killall:
	@docker rm -f $$(docker ps -aq)

.PHONY: stop
stop:
	@docker rm -f "$(CONTAINER)"
