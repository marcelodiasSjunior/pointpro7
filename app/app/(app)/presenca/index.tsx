import React, { useEffect, useRef, useState } from 'react';
import { Camera, CameraType } from 'expo-camera';
import * as FaceDetector from 'expo-face-detector';
import { Alert, Text, View } from 'react-native';
import CustomButton from '../../../components/CustomButton';
import { styles } from './styles';
import { usePresencaStore } from '../../../store/presenca';
import UploadService from '../../../services/funcionario/upload';
import CustomSpinner from '../../../components/CustomSpinner/CustomSpinner';
import { useAuthStore } from '../../../store/auth';
import Colors from '../../../constants/Colors';


const Presenca: React.FC = () => {
    const [camera, setCamera] = useState(null);
    const { data, loading, loadData } = usePresencaStore();
    const [spinner, setSpinner] = useState(false);
    const user = useAuthStore((state) => state.user)

    const handleFacesDetected = ({ faces }) => {
    };

    const [permission, requestPermission] = Camera.useCameraPermissions();
    const [imagePadding, setImagePadding] = useState(0);

    useEffect(() => {
        loadData()
    }, [spinner])

    if (!permission) {
        requestPermission();
    }

    if (!permission?.granted) {
        return <></>
    }

    const getBatidaType = (index: number) => {
        let result = '';
        switch (index) {
            case 0:
                result = 'Inicio da jornada:'
                break;
            case 1:
                result = 'Inicio do intervalo:'
                break;
            case 2:
                result = 'Fim do intervalo:'
                break;
            case 3:
                result = 'Fim da jornada:'
                break;
        }

        return result
    }

    const getPicture = async () => {
        if (camera) {
            const options = {
                quality: 0.5,
                base64: false,
                width: 700,
                fixOrientation: true,
                forceUpOrientation: true
            };

            return camera.takePictureAsync(options);
        }

    };

    const showAlert = (title: string, message: string) => {
        Alert.alert(title, message, [
            { text: 'OK' },
        ]);
    }

    function dataURItoBlob(dataURI: string) {
        // convert base64/URLEncoded data component to raw binary data held in a string
        var byteString;
        if (dataURI.split(',')[0].indexOf('base64') >= 0)
            byteString = atob(dataURI.split(',')[1]);
        else
            byteString = unescape(dataURI.split(',')[1]);
    
        // separate out the mime component
        var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
    
        // write the bytes of the string to a typed array
        var ia = new Uint8Array(byteString.length);
        for (var i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }
    
        return new Blob([ia], {type:mimeString});
    }

    const enviarBatida = async () => {
        setSpinner(true);
        try {

            //Verifica se o endereço bate
   

            const pictureData: any = await getPicture();
            // Loading here
            let filename = 'test.jpeg';
            let pictureUri = pictureData?.uri;
            let typeUpload = 'fileUri';
            if (pictureUri.includes('base64')) {
                typeUpload = 'blob'
            } else {
                filename = pictureData.uri.split('/').reverse()[0]
            }

            const direction = !data?.ultimaBatidaPontoHoje || data?.totalBatidasPontoHoje === 2 ? 1 : 2;
            const response = await UploadService.recognizeFace(
                pictureUri,
                filename,
                'image/jpeg',
                data.api_token_for_web,
                direction,
                typeUpload
            );
            const { msg, user_id } = response;
            if (msg && msg == 'face_not_found_on_database') {
                showAlert('Erro', 'Face não encontrada no banco de dados!')
            }
            if (user.id === user_id) {
                loadData();
            }
            setSpinner(false);

        } catch (e) {
            setSpinner(false);
        }
    }

    return (
        <>
            {spinner && <CustomSpinner show={true} />}

            <View style={styles.pageWrapper}>
                <View style={styles.cameraWrapper}>
                    <Camera
                        ref={(ref) => {
                            setCamera(ref);
                        }}
                        ratio={"1:1"}
                        type={CameraType.front}
                        style={[styles.cameraPreview, { marginTop: imagePadding, marginBottom: imagePadding }]}
                        onFacesDetected={handleFacesDetected}
                        faceDetectorSettings={{
                            mode: FaceDetector.FaceDetectorMode.fast,
                            detectLandmarks: FaceDetector.FaceDetectorLandmarks.none,
                            runClassifications: FaceDetector.FaceDetectorClassifications.none,
                            minDetectionInterval: 100,
                            tracking: true,
                        }}
                    />
                </View>
                <View>
                    {!data?.ultimaBatidaPontoHoje && <CustomButton title="Iniciar jornada" onSubmit={enviarBatida} />}
                    {data?.ultimaBatidaPontoHoje && data?.totalBatidasPontoHoje === 1 && <CustomButton title="Iniciar pausa" onSubmit={enviarBatida} />}
                    {data?.ultimaBatidaPontoHoje && data?.totalBatidasPontoHoje === 2 && <CustomButton title="Finalizar pausa" onSubmit={enviarBatida} />}
                    {data?.ultimaBatidaPontoHoje && data?.totalBatidasPontoHoje === 3 && <CustomButton title="Finalizar jornada" onSubmit={enviarBatida} />}
                    {data?.ultimaBatidaPontoHoje && data?.totalBatidasPontoHoje === 4 && <CustomButton title="Jornada encerrada" />}

                    {data?.batidasPontoHoje.map((item: any, index: number) => {
                        return (
                            <Text style={{ textAlign: 'center', borderBottomColor: Colors.primary, borderBottomWidth: 0.5, paddingVertical: 10 }} key={String(Math.random() + index)}>
                                {getBatidaType(index)} {item.ponto.split(' ')[1]}
                            </Text>
                        )
                    })}
                </View>
            </View>
        </>
    );
}




export default Presenca;