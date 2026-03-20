import { initializeApp } from "firebase/app";
import { getAnalytics, isSupported } from "firebase/analytics";
import { getFirestore, collection, addDoc } from "firebase/firestore";
import { getAuth } from "firebase/auth";
import { getMessaging } from "firebase/messaging";

const firebaseConfig = {
    apiKey: import.meta.env.VITE_FIREBASE_API_KEY,
    authDomain: import.meta.env.VITE_FIREBASE_AUTH_DOMAIN,
    projectId: import.meta.env.VITE_FIREBASE_PROJECT_ID,
    storageBucket: import.meta.env.VITE_FIREBASE_STORAGE_BUCKET,
    messagingSenderId: import.meta.env.VITE_FIREBASE_MESSAGING_SENDER_ID,
    appId: import.meta.env.VITE_FIREBASE_APP_ID,
    measurementId: import.meta.env.VITE_FIREBASE_MEASUREMENT_ID
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
console.log("Firebase app initialized:", app);

// Initialize Services
const db = getFirestore(app);
const auth = getAuth(app);
const messaging = getMessaging(app);

// Safe Analytics Initialization
let analytics;
isSupported().then((yes) => {
    if (yes) {
        analytics = getAnalytics(app);
        console.log("Analytics initialized:", analytics);
    }
});

// Test Firestore functionality
export const testFirebase = async () => {
  try {
    const docRef = await addDoc(collection(db, "test"), {
      message: "Firebase is working from Emperor Stock Predictor 🚀",
      time: new Date()
    });
    console.log("✅ Firestore write success! Document ID:", docRef.id);
  } catch (e) {
    console.error("❌ Firestore write error:", e);
  }
}

export { app, analytics, db, auth, messaging };
