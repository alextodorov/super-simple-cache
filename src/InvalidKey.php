<?php

namespace SSCache;

use Exception;
use Psr\SimpleCache\InvalidArgumentException;

class InvalidKey extends Exception implements InvalidArgumentException
{
}
