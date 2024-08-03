import React from 'react';
import { StyleSheet, TouchableOpacity } from 'react-native';
import Colors from '../../constants/Colors';
import { Text, View } from '../Themed';

const CustomButton = ({ onSubmit, title }: any) => {
    return (
        <View style={styles.wrapper}>
            <TouchableOpacity style={[styles.button, { backgroundColor: Colors.primary }]} onPress={onSubmit ? onSubmit : () => { }}>
                <Text style={styles.text}>{title}</Text>
            </TouchableOpacity>
        </View>

    );
}


const styles = StyleSheet.create({
    wrapper: {
        width: '100%',
        marginVertical: 8,
        backgroundColor: 'transparent'
    },
    button: {
        height: 40,
        paddingVertical: 4,
        paddingHorizontal: 8,
        borderRadius: 20,
        justifyContent: 'center',
        alignItems: 'center'
    },
    text: {
        color: 'white'
    }
})
export default CustomButton;