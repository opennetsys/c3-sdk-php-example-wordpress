BIN = go run $$GOPATH/src/github.com/c3systems/c3-go/main.go

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

.PHONY: key
key:
	@$(BIN) generate key

PEER := "/ip4/127.0.0.1/tcp/3330/ipfs/QmZPNaCnnR59Dtw5nUuxv33pNXxRqKurnZTHLNJ6LaqEnx"

.PHONY: deploy
deploy:
	@$(BIN) deploy --priv priv.pem --genesis '' --image 1042bc722199 --peer $(PEER)

IMAGE := "1042bc722199"

.PHONY: tx
tx:
	@$(BIN) invokeMethod --payload '["createPost", "hello world", "my content"]' --priv priv.pem --image $(IMAGE) --peer $(PEER)
