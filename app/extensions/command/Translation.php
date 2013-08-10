<?php 
namespace app\extensions\command;
 
use lithium\g11n\Catalog;
 
class Translation extends \lithium\console\Command {
 
    protected $_languages = array('fr');
 
    /**
     * Generate a language files for each translation
     */
    public function create() {
        foreach ($this->_languages as $locale) {
		echo "msgmerge -U resources/g11n/{$locale}/LC_MESSAGES/default.po ";
            $command  = "msgmerge -U resources/g11n/{$locale}/LC_MESSAGES/default.po ";
            $command .= "resources/g11n/message_default.pot";
            passthru($command);
        }
    }
 
    /**
     * Compile a binary for each translation file
     */
    public function compile() {
        foreach ($this->_languages as $locale) {
            $command  = "msgfmt -D resources/g11n/{$locale}/LC_MESSAGES ";
            $command .= "-o resources/g11n/{$locale}/LC_MESSAGES/default.pot default.po";
            passthru($command);
        }
    }
 
    /**
     * Extract all translated strings from the codebase
     */
    public function extract() {
        $data = Catalog::read('code', 'messageTemplate', 'root', array(
            'lossy' => false
        ));
        $scope = 'default';
        return Catalog::write('default', 'messageTemplate', 'root', $data, compact('scope'));
    }
}
?>