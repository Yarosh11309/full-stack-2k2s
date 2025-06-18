<?php

declare(strict_types=1);

namespace app\core;

class Response
{
   public function setStatusCode(HttpStatusCodeEnum $status)
   {
       \http_response_code($status->value);
   }

   public function redirect(string $url): void
   {
       header("Location: $url");
       exit;
   }
}