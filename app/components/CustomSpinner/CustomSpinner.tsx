import React from 'react';
import { ActivityIndicator, StyleSheet, View } from 'react-native';
import Colors from '../../constants/Colors';

const CustomSpinner = ({ show }: any) => {
    if (!show) {
        return <></>
    }
    return (
        <View style={styles.container}>
            <ActivityIndicator size="large" style={styles.spinner} color={Colors.primary} />
        </View>
    )
}

const styles = StyleSheet.create({
    container: {
        position: 'fixed',
        left: 0,
        top: 0,
        width: '100%',
        height: '100%',
        justifyContent: 'center',
        alignItems: 'center',
        backgroundColor: '#fff',
        opacity: 0.9,
        zIndex: 99999999
    },
    spinner: {
        opacity: 1,
    }
});

export default CustomSpinner;