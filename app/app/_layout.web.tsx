import { Slot } from 'expo-router';
import { View } from 'react-native';
import "../i18n.config";

export default function Root() {
    return (
        <View style={{ flex: 1, backgroundColor: 'white' }}>
            <Slot />
        </View>
    );
}