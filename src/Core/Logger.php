<?php


namespace Syllabus\Core;


use Syllabus\log\LoggerInterface;

class Logger implements LoggerInterface
{
    public const LOGGER_TXT_FILE = 'src/log/log.txt';
    
    public function emergency($message, array $context = array())
    {
        // TODO: Implement emergency() method.
    }
    
    public function alert($message, array $context = array())
    {
        // TODO: Implement alert() method.
    }
    
    public function critical($message, array $context = array())
    {
        // TODO: Implement critical() method.
    }
    
    public function error($message, array $context = array())
    {
        // TODO: Implement error() method.
    }
    
    public function warning($message, array $context = array())
    {
        // TODO: Implement warning() method.
    }
    
    public function notice($message, array $context = array())
    {
        // TODO: Implement notice() method.
    }
    
    public function info($message, array $context = array())
    {
        $this->append(self::LOGGER_TXT_FILE,$message,$context);
    }
    
    public function debug($message, array $context = array())
    {
        // TODO: Implement debug() method.
    }
    
    public function log($level, $message, array $context = array())
    {
        // TODO: Implement log() method.
    }
    
    private function append(string $fileName,$message, array $context = array()){
        $current = file_get_contents($fileName);
        $message = $this->format($message, $context);
        $current .= $message;
        file_put_contents($fileName,$current);
    }
    
    private function format($message, array $context = array())
    {
        $timeStamp = new \DateTime();
        
        $format = '['.$timeStamp->format("Y-m-d H:i:s").'] '.$message . "\n";
        foreach ($context as $value){
            $format .= $value."\n";
        }
        return $format;
    }
    
}