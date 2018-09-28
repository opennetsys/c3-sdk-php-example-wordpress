#!/bin/bash

function refresh() {
  make payload/refresh
  docker cp /tmp/$(docker inspect --format '{{.Image}}' "$CONTAINER" | sed -E 's/sha256:([0-9a-zA-Z]{12}).*/\1/')/state.txt "$CONTAINER":/tmp/state.json
  sleep 3
  refresh
}

refresh
