<?php

$mk = new MakeProtocolInfo();
$mk->addLine('namespace pocketmine\network\mcpe\protocol;');
$mk->addLine("interface ProtocolInfo{");
$mk->ScanFile("dot.pk");
$mk->save("output/ProtocolInfo.php");

echo "Finished\n";
sleep(2);
class MakeProtocolInfo{
	public $str = "<?php\n";
	public $lines = [];
	public function addLine($line){
		$this->str = $this->str.$line."\n";
	}

	public function ScanFile($path){
		$files = scandir($path);
		foreach($files as $file){
			if(!(is_dir($file))){
				$exp = explode("_", $file);
				$pkname = $exp[0];
				$other = $exp[1];
				$exp2 = explode(".", $other);
				$pkid = $exp2[0];
				$arr = str_split($pkname);
				if(is_array($arr)){
					$cpkname = "";
					$count = 0;
					foreach($arr as $ch){
						if(ctype_lower($ch)){
							$nch = strtoupper($ch);
							$cpkname = $cpkname.$nch;
						}else{
							if($count === 0){
								$cpkname = $cpkname.$ch;
							}else{
								$cpkname = $cpkname."_".$ch;
							}

						}
						$count++;
					}
				}
				$str = "	const ".$cpkname." = ".$pkid.";";
				$this->lines[$pkid] = $str;

			}
		}
	}
	public function save($path){
		ksort($this->lines);
		foreach($this->lines as $line){
			$this->addLine($line);
		}
		$this->addLine("}");
		file_put_contents($path,$this->str);
	}
}