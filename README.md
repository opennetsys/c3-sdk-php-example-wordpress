# c3-sdk-php-example-wordpress

> WordPress on [C3](https://github.com/c3systems/c3-go) using [c3-sdk-php](https://github.com/c3systems/c3-sdk-php). This is a barebones proof-of-concept.

## Example

Build image

```bash
make build
```

Run image

```bash
make run
```

Send example payload to image

```bash
make payload/create
```

Visit site to see blog post: [http://localhost:8000](http://localhost:8000)

If you have a C3 node running you can test with

```bash
make deploy && make tx
```

## License

[GNU AGPL 3.0](LICENSE)
