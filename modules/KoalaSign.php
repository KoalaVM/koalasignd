<?php
  class __CLASSNAME__ {
    public $depend = array("RawEvent");
    public $name = "KoalaSign";

    public function receiveRaw($name, $data) {
      //
    }

    public function isInstantiated() {
      EventHandling::registerForEvent("rawEvent", $this, "receiveRaw");
      return true;
    }
  }
?>
