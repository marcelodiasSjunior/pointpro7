import { Slot } from 'expo-router';
import { SafeAreaView } from 'react-native-safe-area-context';
import "../i18n.config";

export default function Root() {
    return (
        <SafeAreaView style={{ flex: 1, backgroundColor: 'white' }}>
            <Slot />
        </SafeAreaView>
    );
}