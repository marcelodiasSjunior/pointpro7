import React from 'react';
import { View } from 'react-native';

const FormWrapper: React.FC = ({ children, style }) => {
    return <View style={style}>{children}</View>;
}

export default FormWrapper;