import React from 'react';
import { StyleSheet, View } from 'react-native';

// import { Container } from './styles';

const CustomCard = ({ children, style }: { children: any, stytle: any }) => {
    return <View style={[styles.card, style]}>{children}</View>;
}

const styles = StyleSheet.create({
    card: {
        borderWidth: 0.5,
        borderColor: '#ccc',
        padding: 14,
        margin: 7
    }
})

export default CustomCard;