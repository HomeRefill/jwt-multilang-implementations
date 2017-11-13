# Get Started

Clone this repository:

```
$ git clone git@github.com:HomeRefill/jwt-multilang-implementations.git
```

# Requirements:

On OSX Environment:

- PHP 7.1.11
- Python 2.7.10
- Ruby 2.4.2p198

# Generating test keys

In our tests, we used "123456" as passphrase.

```
$ ssh-keygen -t rsa -b 4096 -f keys/signature.key
$ openssl rsa -in keys/signature.key -outform PEM -pubout -out keys/signature.key.pub
```

# Execute tests:

```
$ bin/runner.sh
```
