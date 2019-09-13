#!/usr/bin/env bash
git clone https://github.com/dejbug/od-gov-rs-php
cp -rfu od-gov-rs-php/htdocs/* ../
rm -rf od-gov-rs-php
