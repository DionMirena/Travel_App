<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $question = strtolower(trim($_POST["question"]));
    
    require 'db.php';
    $popular_places = [];
    try {
        $stmt = $pdo->query("SELECT name FROM places LIMIT 5");
        $popular_places = $stmt->fetchAll(PDO::FETCH_COLUMN);
    } catch (Exception $e) {
        $popular_places = ['Paris', 'Barcelona', 'Rome', 'London', 'Dubai'];
    }

    $places_list = implode(', ', $popular_places);
    
    $answers = [
        "hello" => "Hi there! 👋 I'm your travel assistant. I can help you find hotels, book trips, or answer any travel questions!",
        "hi" => "Hello! Ready to plan your next adventure? Where would you like to go?",
        "hey" => "Hey there! 🌍 Need help with travel plans?",
        
        "help" => "I can help you with:\n\n• 🏨 Finding and booking hotels\n• 📍 Destination information\n• 💰 Price comparisons\n• 📅 Booking dates & availability\n• ❓ General travel advice\n• 🎯 Popular destinations: $places_list\n\nWhat would you like to know?",
        "what can you do" => "I'm your travel expert! I can:\n• Show hotel options\n• Help with bookings\n• Provide destination guides\n• Answer travel questions\n• Suggest popular places\n\nTry asking about a specific city or hotel!",
        
        "how to book" => "Booking is easy! 🎯\n\n1. Choose a destination from the main page\n2. Click 'View Hotels & Book'\n3. Select your dates\n4. Choose room type\n5. Complete payment\n\nNeed help with a specific step?",
        "book" => "Ready to book? 🏨\n\n1. Browse destinations on the main page\n2. Click any city to see hotels\n3. Select dates and room\n4. Complete your booking\n\nWhich city are you interested in?",
        "reservation" => "For reservations:\n• Browse our destinations\n• Select your dates\n• Choose from available hotels\n• Secure booking with payment\n\nAll bookings include 24/7 support!",
        
        "hotel" => "Great choice! 🏨 We have hotels in:\n$places_list\n\nWhich city are you looking at? I can tell you more about available options!",
        "hotels" => "We offer various hotels in:\n$places_list\n\nHotels include amenities like:\n• Free WiFi\n• Breakfast options\n• Swimming pools\n• Airport transfers\n\nWhich destination interests you?",
        
        "price" => "💰 Hotel prices vary by:\n• Destination\n• Season\n• Room type\n• Amenities\n\nAverage prices range from $80-$300 per night.\nCheck specific hotels for exact rates!",
        "how much" => "Prices depend on:\n• City (Paris: $120-250, Barcelona: $85-180)\n• Season (peak vs off-peak)\n• Room type (standard vs suite)\n\nWhich city and dates are you considering?",
        "expensive" => "We have options for every budget! 💰\n• Budget: $80-120/night\n• Mid-range: $120-200/night\n• Luxury: $200-300+/night\n\nLet me know your budget and I'll suggest options!",
        "cheap" => "Looking for great deals? 🎯\n\nBudget-friendly options available in all cities! Prices start from $80/night.\n\nPopular affordable destinations:\n• Barcelona from $85\n• Rome from $95\n• Istanbul from $90",
        
        "paris" => "Paris 🇫🇷 - The romantic city!\n• Eiffel Tower & Louvre\n• Romantic cafes\n• Average hotel: $120-250/night\n• Best for: Couples, art lovers\n\nClick Paris on the main page to see hotels!",
        "barcelona" => "Barcelona 🇪🇸 - Vibrant & sunny!\n• Gaudí architecture\n• Beautiful beaches\n• Average hotel: $85-180/night\n• Best for: Culture, nightlife\n\nPerfect for summer trips!",
        "rome" => "Rome 🇮🇹 - Ancient history!\n• Colosseum & Vatican\n• Amazing food\n• Average hotel: $95-200/night\n• Best for: History, food lovers\n\nGreat year-round destination!",
        "london" => "London 🇬🇧 - Royal & modern!\n• Buckingham Palace\n• World-class museums\n• Average hotel: $150-280/night\n• Best for: Culture, shopping\n\nDon't miss the West End shows!",
        "dubai" => "Dubai 🇦🇪 - Luxury & innovation!\n• Burj Khalifa\n• Luxury shopping\n• Average hotel: $200-400/night\n• Best for: Luxury, adventure\n\nPerfect for winter sun!",
        "tokyo" => "Tokyo 🇯🇵 - Futuristic & traditional!\n• Cutting-edge technology\n• Ancient temples\n• Average hotel: $130-250/night\n• Best for: Food, technology\n\nAmazing sushi and culture!",
        
        "available" => "Availability depends on:\n• Travel dates\n• Destination\n• Room type\n\nCheck specific hotels for real-time availability!",
        "date" => "For the best dates:\n• Book 2-3 weeks in advance\n• Avoid peak seasons\n• Consider weekdays for better rates\n\nWhen are you planning to travel?",
        "when" => "Best times to travel:\n• Europe: Spring/Fall\n• Beach destinations: Summer\n• Cities: Year-round\n• Ski resorts: Winter\n\nWhere and when are you thinking?",
        
        "payment" => "We accept:\n• 💳 All major credit cards\n• 💰 PayPal\n• 🏦 Bank transfer\n\nAll payments are secure and encrypted!",
        "pay" => "Secure payment options:\n• Credit/Debit Cards\n• PayPal\n• Safe & encrypted\n• Instant confirmation\n\nYour financial security is our priority!",
        "secure" => "Your security is guaranteed! 🔒\n• SSL encrypted payments\n• PCI compliant\n• Data protection\n• 24/7 fraud monitoring\n\nBook with confidence!",
        
        "cancel" => "Cancellation policies:\n• Free cancellation within 24h\n• Flexible options available\n• Manage bookings in 'My Bookings'\n• 24/7 support for help\n\nNeed to cancel a specific booking?",
        "refund" => "Refund policies:\n• 24-hour free cancellation\n• Refunds processed in 5-7 days\n• Contact support for assistance\n• Check booking terms for details",
        "support" => "We're here to help! 📞\n• 24/7 customer support\n• Email: support@travelapp.com\n• Phone: +1-555-TRAVEL\n• Live chat available\n\nHow can we assist you?",
        
        "wifi" => "Most hotels offer:\n• Free WiFi 📶\n• High-speed internet\n• Business centers\n• Streaming compatible\n\nCheck specific hotel details for amenities!",
        "breakfast" => "Breakfast options:\n• Many hotels include breakfast\n• Continental or buffet\n• Dietary options available\n• Room service\n\nFilter by 'breakfast included' when booking!",
        "pool" => "Looking for pools? 🏊\n• Many hotels have swimming pools\n• Indoor/outdoor options\n• Family-friendly\n• Luxury resorts\n\nI can help find pool hotels!",
        
        "airport" => "Airport transfers:\n• Many hotels offer shuttle service\n• Taxi services available\n• Public transport options\n• Private transfers\n\nNeed help with airport transport?",
        "transport" => "Transport options:\n• Airport transfers\n• Public transportation\n• Rental cars\n• Taxi services\n• Walking-friendly cities\n\nWhich city's transport do you need?",
        
        "family" => "Family-friendly features:\n• Family rooms available\n• Kids' activities\n• Swimming pools\n• Nearby attractions\n• Babysitting services\n\nPerfect for family vacations!",
        "romantic" => "Romantic getaways 💕:\n• Paris for couples\n• Luxury suites\n• Private balconies\n• Spa packages\n• Fine dining\n\nGreat for honeymoons & anniversaries!",
        "business" => "Business travel 🏢:\n• Business centers\n• Meeting rooms\n• High-speed WiFi\n• Airport proximity\n• Executive lounges\n\nPerfect for corporate trips!",
        
        "recommend" => "Based on popularity:\n🌟 Paris - Romantic & cultural\n🌞 Barcelona - Beaches & architecture\n🏛️ Rome - History & food\n🏙️ London - Royal & modern\n💎 Dubai - Luxury & adventure\n\nWhich type of trip are you planning?",
        "best" => "Top destinations:\n🥇 Paris - Most romantic\n🥈 Barcelona - Best beaches\n🥉 Rome - Rich history\n🎖️ London - Cultural hub\n🏅 Dubai - Luxury experience\n\nWhat's your travel style?",
        "weather" => "Weather tips:\n• Europe: Mild summers, cold winters\n• Dubai: Hot year-round\n• Beach destinations: Warm summers\n• Check forecasts before booking\n\nWhich destination's weather?",
        
        "thank" => "You're very welcome! 😊 Happy to help with your travel plans. Let me know if you need anything else!",
        "thanks" => "My pleasure! 🌟 Enjoy planning your trip. Reach out if you have more questions!",
        "bye" => "Goodbye! 👋 Safe travels and have an amazing journey! Bon voyage! ✈️",
        "goodbye" => "See you soon! 🎒 Wishing you wonderful adventures ahead! Travel safe!"
    ];

    $response = "I'm here to help with your travel plans! 🌍\n\nTry asking about:\n• Hotels in specific cities\n• Booking process\n• Prices & deals\n• Destination recommendations\n• Travel tips\n\nOr type 'help' for more options!";

    if (isset($answers[$question])) {
        $response = $answers[$question];
    } else {
        foreach ($answers as $key => $value) {
            if (strpos($question, $key) !== false) {
                $response = $value;
                break;
            }
        }
        
        foreach ($popular_places as $place) {
            if (strpos($question, strtolower($place)) !== false) {
                $response = $answers[strtolower($place)] ?? "Great choice! $place is an amazing destination. Click on $place from the main page to see available hotels and book your stay! 🏨";
                break;
            }
        }
    }

    if (strpos($question, 'how') !== false || strpos($question, 'what') !== false) {
        $tips = [
            "\n💡 Tip: Book in advance for better deals!",
            "\n💡 Tip: Check multiple dates for best prices!",
            "\n💡 Tip: Read hotel reviews before booking!",
            "\n💡 Tip: Consider travel insurance!",
            "\n💡 Tip: Pack according to destination weather!"
        ];
        $response .= $tips[array_rand($tips)];
    }

    echo $response;
    exit;
}

echo "Hello! I'm your travel assistant. How can I help you today?";
?>