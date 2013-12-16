//usart.c
//This file contains the usart communication functions
//**********************************************//
// USART Commucation Functions                  //
//**********************************************//
// http://forum.josephn.net/viewtopic.php?f=19&t=75
//http://www.josephn.net/avr/usart_and_eeprom_on_avr_atmega8515

#include "usart.h"

//Taken from datasheet pg141
//http://www.atmel.com/images/doc2512.pdf
static FILE serial_stream = FDEV_SETUP_STREAM (USART_Transmit, USART_Receive, _FDEV_SETUP_RW);
void USART_Init( unsigned int baud )
{
	cli();
	UBRRH = (unsigned char)(baud>>8);
	UBRRL = (unsigned char)baud;
	
	/* Enable receiver and transmitter */
	UCSRB = (1<<RXEN)|(1<<TXEN);
	
	/* Set frame format: 8data, 1stop bit */
	//UCSRC = (1<<URSEL)|(3<<UCSZ0);
	
	/* Set frame format: 8data, 2stop bit, no parity */
	UCSRC = (1<<URSEL)|(1<<USBS)|(3<<UCSZ0);
	
	//so printf goes to the serial stream
	stdin=&serial_stream;
	stdout=&serial_stream;
	
	//Enable global Interupt
	sei();
}

//Taken from datasheet pg142
//http://www.atmel.com/images/doc2512.pdf
int USART_Transmit( unsigned char data, FILE * fp)
{
	/* Wait for empty transmit buffer */
	while ( !( UCSRA & (1<<UDRE)) )	
	;
	/* Put data into buffer, sends the data */
	UDR = data;
	
	return 0;
}

void USART_Transmit_String( char* txData )
{
	char success = 0;
	int i = 0;
	while (*txData) {
		//USART_Transmit(*txData);
		txData++;
	}

}

int USART_Receive( FILE * fp )
{
	/* Wait for data to be received */
	while ( !(UCSRA & (1<<RXC)) )
	;
	/* Get and return received data from buffer */
	return UDR;
}

void USART_Flush( void )
{
	unsigned char dummy;
	while ( UCSRA & (1<<RXC) ) dummy = UDR;
}
/************************************************************************/
/*    End of USART Commucation Functions                                */
/************************************************************************/
