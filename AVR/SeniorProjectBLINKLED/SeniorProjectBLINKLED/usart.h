#ifndef usart_h
#define usart_h

#include "defines.h"

#ifdef __cplusplus
extern "C" {
	#endif
	

	//USART Commutation
	void USART_Init( unsigned int baud );
	int USART_Transmit( unsigned char data, FILE *fp);
	void USART_Transmit_String( char* txData );
	int USART_Receive( FILE *fp );
	void USART_Flush( void );

	
	#ifdef __cplusplus
}
#endif

#endif