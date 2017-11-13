#!/usr/bin/env bash

verify_token_with() {
  technology=$1
  binary=$2
  extension=$3
  token=$4

  echo -n "== verifing with ${technology} ..."
  $binary $technology/verify.$extension $token > /dev/null 2>&1
  exit_status=$?

  if [[ $exit_status == 1 ]]; then
    echo -n -e "\r== verifing with ${technology} (fail)" ;
  else
    echo -n -e "\r== verifing with ${technology} (ok)" ;
  fi

  echo ""
}

create_test_using() {
  technology=$1
  binary=$2
  extension=$3
  echo "-- creating token using \"${technology}\""
  token=$($binary $technology/create.$extension)
  verify_token_with php $(which php) php $token
  verify_token_with ruby $(which ruby) rb $token
}

create_test_using php $(which php) php
create_test_using ruby $(which ruby) rb
