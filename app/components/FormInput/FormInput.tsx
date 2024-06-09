import React from 'react';
import { StyleSheet, TextInput, View } from 'react-native';
import { Controller } from "react-hook-form"
import { Text, useThemeColor } from '../Themed';
import Colors from '../../constants/Colors';

const FormInput: React.FC = ({ control, errors, placeholder, name }: any) => {
  
    return (
        <View style={[styles.wrapper]}>
            <Controller
                control={control}
                rules={{
                    required: true,
                }}
                render={({ field: { onChange, onBlur, value } }) => (
                    <TextInput
                        placeholder={placeholder}
                        onBlur={onBlur}
                        onChangeText={onChange}
                        value={value}
                        style={[styles.input]}
                    />
                )}
                name={name}
            />
            {errors[name] && <Text>O campo [name] e obrigatorio.</Text>}
        </View>
    )
}


const styles = StyleSheet.create({
    wrapper: {
        width: '100%',
        marginVertical: 8
    },
    input: {
        backgroundColor: '#fff',
        borderWidth: 1,
        borderColor: 'black',
        height: 40,
        paddingHorizontal: 20,
        borderRadius: 20
    }
});


export default FormInput;