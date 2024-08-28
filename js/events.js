import React, { useState, useEffect } from 'react';
import { View, Text, StyleSheet, FlatList, ActivityIndicator, Button, Alert, TouchableOpacity } from 'react-native';

const EventsScreen = ({ navigation }) => {
    const [events, setEvents] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        const fetchEvents = async () => {
            try {
                const response = await fetch('https://void.stud.vts.su.ac.rs/events_api.php');
                const data = await response.json();

                if (data.success) {
                    setEvents(data.events);
                } else {
                    setError(data.message);
                }
            } catch (err) {
                setError('Hiba történt az események lekérésekor.');
            } finally {
                setLoading(false);
            }
        };

        fetchEvents();
    }, []);

    const handleDelete = async (eventId) => {
        try {
            const response = await fetch('https://void.stud.vts.su.ac.rs/delete_event_api.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: eventId }),
            });

            const data = await response.json();

            if (data.success) {
                Alert.alert('Success', data.message);
                // Refresh the event list after deletion
                setEvents(events.filter(event => event.id !== eventId));
            } else {
                Alert.alert('Error', data.message);
            }
        } catch (err) {
            Alert.alert('Error', 'Hiba történt az esemény törlésekor.');
        }
    };

    const handleEdit = (event) => {
        // Navigate to edit screen with event data
        navigation.navigate('EditEvent', { event });
    };

    const handleCreateEvent = () => {
        // Navigate to create event screen
        navigation.navigate('CreateEvent');
    };

    if (loading) {
        return (
            <View style={styles.container}>
                <ActivityIndicator size="large" color="#0000ff" />
                <Text>Loading...</Text>
            </View>
        );
    }

    if (error) {
        return (
            <View style={styles.container}>
                <Text style={styles.error}>{error}</Text>
            </View>
        );
    }

    return (
        <View style={styles.container}>
            <FlatList
                data={events}
                keyExtractor={(item) => item.id.toString()}
                renderItem={({ item }) => (
                    <View style={styles.eventCard}>
                        <Text style={styles.title}>{item.name}</Text>
                        <Text>Date: {item.event_date}</Text>
                        <Text>Place: {item.place}</Text>
                        <Text>Type: {item.type}</Text>
                        <Text>Comment: {item.comment}</Text>
                        <View style={styles.buttonsContainer}>
                            <TouchableOpacity
                                style={styles.button}
                                onPress={() => handleEdit(item)}
                            >
                                <Text style={styles.buttonText}>Edit</Text>
                            </TouchableOpacity>
                            <TouchableOpacity
                                style={styles.button}
                                onPress={() => handleDelete(item.id)}
                            >
                                <Text style={styles.buttonText}>Delete</Text>
                            </TouchableOpacity>
                        </View>
                    </View>
                )}
            />
            <TouchableOpacity
                style={styles.createButton}
                onPress={handleCreateEvent}
            >
                <Text style={styles.createButtonText}>Create Event</Text>
            </TouchableOpacity>
        </View>
    );
};

const styles = StyleSheet.create({
    container: {
        flex: 1,
        padding: 20,
    },
    eventCard: {
        backgroundColor: '#f9f9f9',
        padding: 15,
        marginVertical: 10,
        borderRadius: 5,
        shadowColor: '#000',
        shadowOffset: { width: 0, height: 2 },
        shadowOpacity: 0.1,
        shadowRadius: 5,
        elevation: 3,
    },
    title: {
        fontSize: 18,
        fontWeight: 'bold',
    },
    buttonsContainer: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        marginTop: 10,
    },
    button: {
        backgroundColor: '#007bff',
        padding: 10,
        borderRadius: 5,
        marginHorizontal: 5,
    },
    buttonText: {
        color: '#fff',
        fontSize: 14,
    },
    createButton: {
        backgroundColor: '#28a745',
        padding: 15,
        borderRadius: 5,
        marginTop: 20,
        alignItems: 'center',
    },
    createButtonText: {
        color: '#fff',
        fontSize: 18,
    },
    error: {
        color: 'red',
        fontSize: 16,
    },
});

export default EventsScreen;
