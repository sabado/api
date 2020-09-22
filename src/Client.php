<?PHP namespace galgo\api;

class Client {

    Private $_Key = false;
    Private $_Host = false;
    
    Public Function __construct(string $Key,string $Host){

        $this->_Key = $Key;
        $Host .= ( substr( $Host, -1 ) != '/' ) ? '/' : '';
        $this->_Host = $Host;

    }

    Public Function Get( string $Route, array $Args ): array{

	$Endpoint = $this->_Host . $Route;
	$String = '';

	foreach($Args as $Arg ){
		$String .= ( $String == '' ) ? '?' : '&' ; 
		$String .= $Arg[0] . '=' . $Arg[1];
	}

	$Endpoint .= $String ;

	$Options  = [
            'http' => [
                'header' => [
                    'X-Auth: ' . $this->_Key,
                    'Content-type: application/json'
                ],
                'method' => 'GET'
            ]
        ];

        return $this->_Send( $Endpoint, $Options );

    }



    Public Function Post( string $Route, array $Payload ): array {

        $Endpoint = $this->_Host . $Route;
        $Payload  = json_encode( $Payload );

        $Options  = [
            'http' => [
                'header' => [
                    'X-Auth: ' . $this->_Key,
                    'Content-type: application/json'
                ],
                'method' => 'POST',
                'content' => $Payload
            ]
        ];

	return $this->_Send( $Endpoint, $Options );

    }

    Private Function _Send( $Endpoint, $Options ): array { 
        $Context  = stream_context_create( $Options );
        $Response = file_get_contents( $Endpoint, false, $Context );

        /** Error de host */
        if( $Response === false ) 
            return [
                'Success' => false,
                'Error'   => 'Cannot send contents to endpoint'
            ];

        $ResponseArray = json_decode( $Response, true );

        /** Error en la respuesta */
        if( $ResponseArray === null ) 
            return [
                'Success'  => false,
                'Error'    => 'Response is not a json object',
                'Response' => $Response
            ];
        
        /** Respuesta Satisfactoria */
        
        return [
            'Success'  => true,
            'Response' => $ResponseArray
        ];
    }


}
