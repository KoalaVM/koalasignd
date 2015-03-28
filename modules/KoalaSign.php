<?php
  class __CLASSNAME__ {
    public $depend = array("RawEvent");
    public $name = "KoalaSign";
    private $gpg = null;

    public function receiveRaw($name, $data) {
      $connection = $data[0];
      $data = json_decode($data[1], true);

      if (is_array($data) && isset($data["command"])) {
        $data      = base64_encode(json_encode($data));
        $signature = base64_encode(trim(gnupg_sign($this->gpg, $data)));
        $connection->send(json_encode(array(
          "status"  => "200",
          "message" => "Success: the requested payload was signed",
          "data"    => json_encode(array(
              "payload64" => $data,
              "signature" => $signature
            ))
        )));
        $connection->disconnect();
      }
      else {
        // Malformed request
        $connection->send(json_encode(array(
          "status"  => "400",
          "message" => "Malformed request: the provided data was not a JSON ".
            "array, or did not contain they 'command' key"
        )));
      }
    }

    public function isInstantiated() {
      $seckey = StorageHandling::loadFile($this, "gpg.sec");
      if ($seckey != false && $seckey != null) {
        $this->gpg = gnupg_init();
        $info = gnupg_import($this->gpg, $seckey);
        Logger::debug(var_export($info, true));
        if (is_array($info) && isset($info["fingerprint"]) &&
            gnupg_addsignkey($this->gpg, $info["fingerprint"]) == true) {
          EventHandling::registerForEvent("rawEvent", $this, "receiveRaw");
          return true;
        }
      }
      StorageHandling::saveFile($this, "gpg.sec", null);
      Logger::info("Failed to load the master's GPG secret key for KoalaCore.");
      Logger::info("Place the secret key in a file at data/KoalaCore/gpg.sec");
      return false;
    }
  }
?>
