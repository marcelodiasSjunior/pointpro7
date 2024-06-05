import React from 'react';

const FormWrapper: React.FC = ({ children, style }) => {
    return <form style={style}>{children}</form>;
}

export default FormWrapper;