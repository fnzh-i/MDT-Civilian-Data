<?php
enum ExpiryOption: int
{
  case FIVE_YEARS = 5;
  case TEN_YEARS = 10;

  public function getInterval(): DateInterval
  {
    return new DateInterval("P{$this->value}Y");
  }
}
?>