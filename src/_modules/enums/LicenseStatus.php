<?php
enum LicenseStatus: string
{
  case REGISTERED = "REGISTERED";
  case UNREGISTERED = "UNREGISTERED";
  case EXPIRED = "EXPIRED";
  case REVOKED = "REVOKED";
}
?>