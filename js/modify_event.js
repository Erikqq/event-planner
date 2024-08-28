    const handleUpdate = async () => {
        const response = await fetch('https://void.stud.vts.su.ac.rs/modify_event_api.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                id: eventId,
                ...event
            }),
        });

        const data = await response.json();

        if (data.success) {
            Alert.alert('Success', data.message);
            navigation.goBack();
        } else {
            Alert.alert('Error', data.message);
        }
    };