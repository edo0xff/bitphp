<?php namespace BitPHP\ApiServer;

	use \DOMDocument;
  	use \SimpleXMLElement;

	class XmlArrayParser {

		private function arrayToXml($student_info, &$xml_student_info) {
      		foreach($student_info as $key => $value) {
        		if(is_array( $value )) {
            		if(!is_numeric( $key )){
                		$subnode = $xml_student_info->addChild( $key );
                		$this->array_to_xml( $value, $subnode );
            		} else {
                		$subnode = $xml_student_info->addChild( "item" );
                		//$subnode->addAttribute( 'id',$key );
                		$this->array_to_xml( $value, $subnode );
            		}
        		} else {
            		$xml_student_info->addChild( $key,$value );
        		}
      		}
    	}

    	public function parse( $data ) {
    		$xml = new SimpleXMLElement("<?xml version=\"1.0\"?><root></root>");
        	self::arrayToXml( $data, $xml );
			return $xml->asXML();
    	}
	}