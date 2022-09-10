<?php

namespace SSCache;

use Exception;
use Psr\SimpleCache\InvalidArgumentException;

class InvalidArgument extends Exception implements InvalidArgumentException
{
}
