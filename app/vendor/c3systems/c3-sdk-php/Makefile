all:
	@echo "no default"

.PHONY: install
install:
	@composer install

.PHONY: validate
validate:
	@composer validate

.PHONY: test
test: test/client test/util test/hexutil test/hashutil

.PHONY: test/client
test/client:
	@php tests/ClientTest.php

.PHONY: test/util
test/util:
	@php tests/UtilTest.php

.PHONY: test/hexutil
test/hexutil:
	@php tests/HexutilTest.php

.PHONY: test/hashutil
test/hashutil:
	@php tests/HashutilTest.php

.PHONY: test/payload
test/payload:
	@echo '["setItem", "foo", "bar"]' |  nc localhost 3330

.PHONY: run/example
run/example:
	@php example/example.php
