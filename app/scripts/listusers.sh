#!/bin/bash
awk -F/ '$NF == "zsh"' /etc/passwd
