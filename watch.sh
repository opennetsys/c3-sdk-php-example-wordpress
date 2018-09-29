#!/bin/bash

function refresh() {
  IMAGE=$(docker inspect --format '{{.Image}}' "$CONTAINER" | sed -E 's/sha256:([0-9a-zA-Z]{12}).*/\1/')
  TMP_PATH="/tmp/$IMAGE"
  TMP_PATH="/tmp/9d09348a1c55"
  cp "$TMP_PATH/state.txt" "$TMP_PATH/state.json"
  docker cp "$TMP_PATH/state.json" "$CONTAINER":/tmp
  make payload/refresh
  sleep 5
  refresh
}

refresh
