<?php

class fontAwesomeFieldType extends eZDataType {

    const DATA_TYPE_STRING = 'fontawesomefield';

    function fontAwesomeFieldType() {
        $this->eZDataType( self::DATA_TYPE_STRING,
                            'FontAwesome Field',
                            array( 'serialize_supported' => TRUE,
                                    'object_serialize_map' => array( 'data_text' => 'character' ) ) );
    }

    /*!
     Fetches characters list from ini.
    */
    static function fetchCharacterList()
    {
        if ( isset( $GLOBALS['CharacterList'] ) )
            return $GLOBALS['CharacterList'];

        $ini = eZINI::instance( 'fontAwesomeChars.ini' );
        $characters = $ini->variable( 'FontAwesomeSettings', 'CharList' );
        $GLOBALS['CharacterList'] = $characters;
        return $characters;
    }

    /*!
     Sets the default value.
    */
    function initializeObjectAttribute( $contentObjectAttribute, $currentVersion, $originalContentObjectAttribute )
    {
        if ( $currentVersion != false )
        {
            $dataText = $originalContentObjectAttribute->content();
            $contentObjectAttribute->setContent( $dataText );
        }
        else
        {
            $default = array( 'value' => array() );
            $contentObjectAttribute->setContent( $default );
        }
    }

    function validateObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {
        if ( !$contentObjectAttribute->validateIsRequired() )
            return eZInputValidator::STATE_ACCEPTED;

        if ( $http->hasPostVariable( $base . '_fontawesomefield_' . $contentObjectAttribute->attribute( 'id' ) ) )
        {
            $data = $http->postVariable( $base . '_fontawesomefield_' . $contentObjectAttribute->attribute( 'id' ) );

            if ( $data != '' )
                return eZInputValidator::STATE_ACCEPTED;
        }

        $contentObjectAttribute->setValidationError( ezpI18n::tr( 'kernel/classes/datatypes',
            'Input required.' ) );
        return eZInputValidator::STATE_INVALID;
    }

    function validateCollectionAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {
        if ( !$contentObjectAttribute->validateIsRequired() )
            return eZInputValidator::STATE_ACCEPTED;

        if ( $http->hasPostVariable( $base . '_fontawesomefield_' . $contentObjectAttribute->attribute( 'id' ) ) )
        {
            $data = $http->postVariable( $base . '_fontawesomefield_' . $contentObjectAttribute->attribute( 'id' ) );

            if ( $data != '' )
                return eZInputValidator::STATE_ACCEPTED;
        }

        $contentObjectAttribute->setValidationError( ezpI18n::tr( 'kernel/classes/datatypes',
            'Input required.' ) );
        return eZInputValidator::STATE_INVALID;
    }

    /*!
     Fetches the http post var and stores it in the data instance.
    */
    function fetchObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {
        if ( $http->hasPostVariable( $base . '_fontawesomefield_' . $contentObjectAttribute->attribute( 'id' ) ) )
        {
            $value = $http->postVariable( $base . '_fontawesomefield_' . $contentObjectAttribute->attribute( 'id' ) );
            $content = array( 'value' => $value );
            $contentObjectAttribute->setContent( $content );
        }
        else
        {
            $content = array( 'value' => array() );
            $contentObjectAttribute->setContent( $content );
        }
        return true;
    }

    /*!
     Fetches the http post variables for collected information
    */
    function fetchCollectionAttributeHTTPInput( $collection, $collectionAttribute, $http, $base, $contentObjectAttribute )
    {
        if ( $http->hasPostVariable( $base . "_fontawesomefield_" . $contentObjectAttribute->attribute( "id" ) ) )
        {
            $value = $http->postVariable( $base . "_fontawesomefield_" . $contentObjectAttribute->attribute( "id" ) );

            $collectionAttribute->setAttribute( 'data_text', $value );
            return true;
        }
        return false;
    }

    function storeObjectAttribute( $contentObjectAttribute )
    {
        $content = $contentObjectAttribute->content();
        $value = $content['value'];
        $contentObjectAttribute->setAttribute( "data_text", $value );
    }

    /*!
     Simple string insertion is supported.
    */
    function isSimpleStringInsertionSupported()
    {
        return true;
    }

    function insertSimpleString( $object, $objectVersion, $objectLanguage,
                                 $objectAttribute, $string,
                                 &$result )
    {
        $result = array( 'errors' => array(),
            'require_storage' => true );
        $content = array( 'value' => $string );
        $objectAttribute->setContent( $content );
        return true;
    }

    /*!
     Returns the content.
    */
    function objectAttributeContent( $contentObjectAttribute )
    {
        $value = $contentObjectAttribute->attribute( 'data_text' );
        $content = array( 'value' => $value );
        return $content;
    }

    /*!
     Returns the meta data used for storing search indeces.
    */
    function metaData( $contentObjectAttribute )
    {
        $content = $contentObjectAttribute->content();
        return $content['value'];
    }

    /*!
     Returns string representation of an contentobjectattribute data for simplified export
    */
    function toString( $contentObjectAttribute )
    {
        return $contentObjectAttribute->attribute( 'data_text' );
    }

    function fromString( $contentObjectAttribute, $string )
    {
        return $contentObjectAttribute->setAttribute( 'data_text', $string );
    }

    /*!
     Returns the character for use as a title
    */
    function title( $contentObjectAttribute, $name = null )
    {
        $content = $contentObjectAttribute->content();
        return $content['value'];
    }

    function hasObjectAttributeContent( $contentObjectAttribute )
    {
        $content = $contentObjectAttribute->content();
        $result = ( ( !is_array( $content['value'] ) and trim( $content['value'] ) != '' ) );
        return $result;
    }

    function isIndexable()
    {
        return true;
    }

    function isInformationCollector()
    {
        return true;
    }

    function sortKey( $contentObjectAttribute )
    {
        $trans = eZCharTransform::instance();
        $content = $contentObjectAttribute->content();
        return $trans->transformByGroup( $content['value'], 'lowercase' );
    }

    function sortKeyType()
    {
        return 'string';
    }

    function diff( $old, $new, $options = false )
    {
        return null;
    }

    function supportsBatchInitializeObjectAttribute()
    {
        return true;
    }
}

eZDataType::register( fontAwesomeFieldType::DATA_TYPE_STRING, 'fontAwesomeFieldType' );

?>
