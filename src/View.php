<?PHP namespace galgo\api;

class View {

	Public Static Function JSON( array $Contents, $RetCode=200 ){
	        header( 'Content-Type: application/json' );
                http_response_code( $RetCode );
		echo json_encode( $Contents, JSON_PRETTY_PRINT );
		exit( 0 );
	}

	Public Static Function Text( string $BodyText, $RetCode=200 ){
	        header( 'Content-Type: text/plain' );
		http_response_code( $RetCode );
		echo $BodyText;
		exit ( 0 );
	}

        Public Static Function HTML( string $BodyHtml, $RetCode=200 ){
                header( 'Content-Type: text/html' );
                http_response_code( $RetCode );
                echo $BodyHtml;
                exit ( 0 );
        }

}
