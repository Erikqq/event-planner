import React, { useState } from 'react';
import { View, Text, TextInput, Button, Alert, StyleSheet } from 'react-native';

export default function CreateEvent({ navigation }) {
    const [event, setEvent] = useState({
        name: '',
        event_date: '',
        place: '',
        type: '',
        comment: '',
    });

    const handleCreate = async () => {
        const response = await fetch('https://void.stud.vts.su.ac.rs/create_event_api.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(event),
        });

        const data = await response.json();

        if (data.success) {
            Alert.alert('Success', data.message);
            navigation.goBack();
        } else {
            Alert.alert('Error', data.message);
        }
    };

    return (
        <View style={styles.container}>
            <Text style={styles.title}>Create Event</Text>
            <TextInput
                style={styles.input}
                placeholder="Name"
                value={event.name}
                onChangeText={(text) => setEvent({ ...event, name: text })}
            />
            <TextInput
                style={styles.input}
                placeholder="Event Date"
                value={event.event_date}
                onChangeText={(text) => setEvent({ ...event, event_date: text })}
            />
            <TextInput
                style={styles.input}
                placeholder="Place"
                value={event.place}
                onChangeText={(text) => setEvent({ ...event, place: text })}
            />
            <TextInput
                style={styles.input}
                placeholder="Type"
                value={event.type}
                onChangeText={(text) => setEvent({ ...event, type: text })}
            />
            <TextInput
                style={styles.input}
                placeholder="Comment"
                value={event.comment}
                onChangeText={(text) => setEvent({ ...event, comment: text })}
            />
            <Button title="Create Event" onPress={handleCreate} />
        </View>
    );
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        justifyContent: 'center',
        padding: 20,
    },
    title: {
        fontSize: 24,
        marginBottom: 20,
        textAlign: 'center',
    },
    input: {
        height: 40,
        borderColor: 'gray',
        borderWidth: 1,
        marginBottom: 20,
        padding: 10,
    },
});
