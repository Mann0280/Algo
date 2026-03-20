import { messaging } from "./firebase";
import { getToken, onMessage } from "firebase/messaging";

const VAPID_KEY = import.meta.env.VITE_FIREBASE_VAPID_KEY || ''; // Optional but recommended

export const initNotifications = async () => {
    try {
        if (!("Notification" in window)) {
            console.log("This browser does not support desktop notification");
            return;
        }

        const permission = await Notification.requestPermission();
        if (permission === "granted") {
            const token = await getToken(messaging, {
                vapidKey: VAPID_KEY,
            });

            if (token) {
                console.log("FCM Token Received:", token);
                await saveToken(token);
            } else {
                console.log("No registration token available. Request permission to generate one.");
            }
        }
    } catch (err) {
        console.log("An error occurred while retrieving token. ", err);
    }
};

const saveToken = async (token) => {
    try {
        const response = await fetch("/account/fcm-token", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
            body: JSON.stringify({ token }),
        });
        const data = await response.json();
        console.log("Token saved to server:", data);
    } catch (err) {
        console.log("Failed to save token to server", err);
    }
};

// Listen for Foreground Messages
onMessage(messaging, (payload) => {
    console.log("Message received in foreground: ", payload);
    
    // Show premium toast
    if (window.showAlgoNotification) {
        window.showAlgoNotification(
            payload.notification.title,
            payload.notification.body,
            payload.data.type || 'info'
        );
    }
});
