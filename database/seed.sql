TRUNCATE featured_listings, reports, messages, conversations, listing_images, property_listings, item_listings, password_resets, email_verifications, users RESTART IDENTITY CASCADE;

INSERT INTO users (id, full_name, email, phone, password_hash, role, is_verified, bio) VALUES
(1, 'Admin User', 'admin@fairlymarket.ng', '+2348010000001', '$2y$10$hFiJubQikJmwc5GfnXAnOe.ApaiHzH.AAa7m4sCsPIHCNr3S61kAu', 'admin', true, 'Platform administrator.'),
(2, 'Chinedu Okafor', 'chinedu@example.com', '+2348034567890', '$2y$10$l09IKO1UxybCr81fgqUZCe6VsTCSlJMagdxxA8Xuu8ZnV/geBquyO', 'buyer_seller', true, 'Electronics seller in Ikeja.'),
(3, 'Aisha Bello', 'aisha@example.com', '+2348051112233', '$2y$10$l09IKO1UxybCr81fgqUZCe6VsTCSlJMagdxxA8Xuu8ZnV/geBquyO', 'landlord_tenant', true, 'Property agent covering Lagos mainland.'),
(4, 'Tunde Adeyemi', 'tunde@example.com', '+2348072223344', '$2y$10$l09IKO1UxybCr81fgqUZCe6VsTCSlJMagdxxA8Xuu8ZnV/geBquyO', 'general', true, 'Reliable buyer and seller.'),
(5, 'Ifeoma Nwosu', 'ifeoma@example.com', '+2348093334455', '$2y$10$l09IKO1UxybCr81fgqUZCe6VsTCSlJMagdxxA8Xuu8ZnV/geBquyO', 'buyer_seller', true, 'Furniture and home appliances.'),
(6, 'Yusuf Ibrahim', 'yusuf@example.com', '+2347014445566', '$2y$10$l09IKO1UxybCr81fgqUZCe6VsTCSlJMagdxxA8Xuu8ZnV/geBquyO', 'landlord_tenant', true, 'Abuja property manager.'),
(7, 'Blessing Eze', 'blessing@example.com', '+2348025556677', '$2y$10$l09IKO1UxybCr81fgqUZCe6VsTCSlJMagdxxA8Xuu8ZnV/geBquyO', 'buyer_seller', true, 'Fashion items and books.'),
(8, 'Emeka Obi', 'emeka@example.com', '+2348066667788', '$2y$10$l09IKO1UxybCr81fgqUZCe6VsTCSlJMagdxxA8Xuu8ZnV/geBquyO', 'general', true, 'Vehicle and property listings.'),
(9, 'Fatima Sani', 'fatima@example.com', '+2348087778899', '$2y$10$l09IKO1UxybCr81fgqUZCe6VsTCSlJMagdxxA8Xuu8ZnV/geBquyO', 'landlord_tenant', true, 'Short-let and rental enquiries.'),
(10, 'Kelechi Uche', 'kelechi@example.com', '+2348108889900', '$2y$10$l09IKO1UxybCr81fgqUZCe6VsTCSlJMagdxxA8Xuu8ZnV/geBquyO', 'buyer_seller', true, 'Appliance reseller.'),
(11, 'Ngozi Okonjo', 'ngozi@example.com', '+2348129990011', '$2y$10$l09IKO1UxybCr81fgqUZCe6VsTCSlJMagdxxA8Xuu8ZnV/geBquyO', 'general', true, 'Looking for quality fairly used goods.'),
(12, 'Babatunde Fashola', 'babatunde@example.com', '+2348141011121', '$2y$10$l09IKO1UxybCr81fgqUZCe6VsTCSlJMagdxxA8Xuu8ZnV/geBquyO', 'landlord_tenant', true, 'Lagos landlord.'),
(13, 'Amaka Eze', 'amaka@example.com', '+2348161213141', '$2y$10$l09IKO1UxybCr81fgqUZCe6VsTCSlJMagdxxA8Xuu8ZnV/geBquyO', 'buyer_seller', true, 'Student items and furniture.'),
(14, 'Musa Abdullahi', 'musa@example.com', '+2348181516171', '$2y$10$l09IKO1UxybCr81fgqUZCe6VsTCSlJMagdxxA8Xuu8ZnV/geBquyO', 'landlord_tenant', true, 'Abuja agent.'),
(15, 'Chiamaka Nnamdi', 'chiamaka@example.com', '+2349011819202', '$2y$10$l09IKO1UxybCr81fgqUZCe6VsTCSlJMagdxxA8Xuu8ZnV/geBquyO', 'general', true, 'Careful seller with fast replies.'),
(16, 'Segun Olawale', 'segun@example.com', '+2349032122232', '$2y$10$l09IKO1UxybCr81fgqUZCe6VsTCSlJMagdxxA8Xuu8ZnV/geBquyO', 'buyer_seller', true, 'Office equipment and gadgets.');

INSERT INTO item_listings (id, user_id, title, description, category, condition, price, quantity, status) VALUES
(1, 2, 'Samsung 55-inch Smart TV', 'Clean smart TV with remote and wall bracket.', 'Electronics', 'like-new', 185000, 1, 'active'),
(2, 2, 'Used HP Pavilion Laptop (Core i5)', '8GB RAM, 512GB SSD, battery lasts about four hours.', 'Electronics', 'used', 145000, 1, 'active'),
(3, 5, '6-Seater Dining Set', 'Wooden dining set with six padded chairs.', 'Furniture', 'fair', 95000, 1, 'active'),
(4, 8, 'Toyota Camry 2012', 'Registered Camry, sound engine and AC.', 'Vehicles', 'used', 4200000, 1, 'pending'),
(5, 7, 'Ankara Fabric Bundle (10 yards)', 'Bright Ankara bundle, unused.', 'Fashion', 'new', 18000, 5, 'active'),
(6, 10, 'LG Double Door Fridge', 'Neatly used fridge with freezer compartment.', 'Appliances', 'used', 150000, 1, 'active'),
(7, 13, 'Reading Table and Chair', 'Compact study table with matching chair.', 'Furniture', 'like-new', 22000, 1, 'active'),
(8, 4, 'iPhone 12 Pro Max', '128GB, clean body, Face ID working.', 'Electronics', 'used', 310000, 1, 'sold'),
(9, 10, 'Generator (Sumec Firman 4.5KVA)', 'Starts easily and powers basic home appliances.', 'Appliances', 'fair', 175000, 1, 'active'),
(10, 13, 'Set of Engineering Textbooks', 'Mechanical and electrical engineering textbooks.', 'Books', 'used', 12000, 1, 'active'),
(11, 16, 'Office Executive Chair', 'Adjustable office chair in excellent condition.', 'Furniture', 'like-new', 35000, 2, 'active'),
(12, 8, 'Honda Civic 2015', 'Foreign-used Honda Civic with duty paid.', 'Vehicles', 'used', 6800000, 1, 'active'),
(13, 15, 'Microwave Oven (Binatone)', 'Working microwave oven, lightly used.', 'Appliances', 'used', 28000, 1, 'pending'),
(14, 7, 'Men''s Leather Jacket', 'Black leather jacket, medium size.', 'Fashion', 'like-new', 15000, 1, 'active'),
(15, 16, 'PlayStation 4 with 2 Controllers', 'PS4 console with two pads and three games.', 'Electronics', 'used', 98000, 1, 'active'),
(16, 5, 'Wardrobe (4-Door)', 'Large wardrobe, good for family room.', 'Furniture', 'fair', 60000, 1, 'pending');

INSERT INTO property_listings (id, user_id, title, description, listing_type, property_type, price, rent_period, bedrooms, bathrooms, size_sqft, address, city, state, amenities, status) VALUES
(1, 3, '2-Bedroom Flat in Lekki Phase 1', 'Serviced flat near Admiralty Way.', 'rent', 'apartment', 1800000, 'yearly', 2, 3, 1200, 'Admiralty Way, Lekki Phase 1', 'Lekki', 'Lagos', '["Parking","Water","Electricity"]', 'active'),
(2, 3, 'Self-Contain in Yaba', 'Affordable self-contain close to UNILAG.', 'rent', 'self-contain', 350000, 'yearly', 1, 1, 350, 'Sabo, Yaba', 'Yaba', 'Lagos', '["Water","Electricity"]', 'active'),
(3, 6, '4-Bedroom Duplex in Maitama', 'Luxury duplex with boys quarters.', 'sale', 'duplex', 120000000, NULL, 4, 5, 4200, 'Maitama District', 'Maitama', 'Abuja', '["Parking","Water","Electricity","Furnished"]', 'active'),
(4, 6, '3-Bedroom Apartment in Gwarinpa', 'Spacious apartment in a secure estate.', 'rent', 'apartment', 2500000, 'yearly', 3, 4, 1600, 'Gwarinpa Estate', 'Gwarinpa', 'Abuja', '["Parking","Water","Electricity"]', 'pending'),
(5, 12, 'Mini Flat in Surulere', 'Clean mini flat near Bode Thomas.', 'rent', 'apartment', 600000, 'yearly', 1, 2, 500, 'Bode Thomas Street', 'Surulere', 'Lagos', '["Water","Electricity"]', 'active'),
(6, 12, '5-Bedroom Detached House in Ikoyi', 'Detached house with swimming pool and ample parking.', 'sale', 'house', 350000000, NULL, 5, 6, 6500, 'Bourdillon Road', 'Ikoyi', 'Lagos', '["Parking","Water","Electricity","Furnished"]', 'active'),
(7, 14, 'Studio Apartment in Wuse 2', 'Modern studio apartment for a single professional.', 'rent', 'apartment', 1200000, 'yearly', 1, 1, 430, 'Aminu Kano Crescent', 'Wuse 2', 'Abuja', '["Parking","Water","Electricity","Furnished"]', 'active'),
(8, 8, 'Land for Sale in Epe', 'Dry land with survey and deed documents.', 'sale', 'land', 8500000, NULL, 0, 0, 5400, 'Epe Expressway', 'Epe', 'Lagos', '[]', 'active'),
(9, 14, '2-Bedroom Bungalow in Kubwa', 'Bungalow in a quiet residential area.', 'rent', 'house', 900000, 'yearly', 2, 2, 950, 'Phase 4, Kubwa', 'Kubwa', 'Abuja', '["Parking","Water"]', 'active'),
(10, 3, 'Shop Space in Computer Village, Ikeja', 'Ground floor shop in a busy commercial area.', 'rent', 'commercial', 1500000, 'yearly', 0, 1, 300, 'Otigba Street', 'Ikeja', 'Lagos', '["Electricity"]', 'pending'),
(11, 12, '3-Bedroom Terrace in Lekki', 'Newly built terrace with fitted kitchen.', 'sale', 'house', 95000000, NULL, 3, 4, 2400, 'Chevron Drive', 'Lekki', 'Lagos', '["Parking","Water","Electricity"]', 'active'),
(12, 6, 'Room and Parlour Self-Contain in Garki', 'Budget apartment with prepaid meter.', 'rent', 'self-contain', 450000, 'yearly', 1, 1, 420, 'Area 3, Garki', 'Garki', 'Abuja', '["Water","Electricity"]', 'active');

INSERT INTO listing_images (listing_id, listing_table, image_url) VALUES
(1,'item','https://placehold.co/800x600?text=Samsung+TV+1'),(1,'item','https://placehold.co/800x600?text=Samsung+TV+2'),
(2,'item','https://placehold.co/800x600?text=HP+Laptop+1'),(2,'item','https://placehold.co/800x600?text=HP+Laptop+2'),
(3,'item','https://placehold.co/800x600?text=Dining+Set+1'),(3,'item','https://placehold.co/800x600?text=Dining+Set+2'),
(4,'item','https://placehold.co/800x600?text=Toyota+Camry+1'),(4,'item','https://placehold.co/800x600?text=Toyota+Camry+2'),
(5,'item','https://placehold.co/800x600?text=Ankara+Fabric+1'),(5,'item','https://placehold.co/800x600?text=Ankara+Fabric+2'),
(6,'item','https://placehold.co/800x600?text=LG+Fridge+1'),(6,'item','https://placehold.co/800x600?text=LG+Fridge+2'),
(7,'item','https://placehold.co/800x600?text=Reading+Table+1'),(7,'item','https://placehold.co/800x600?text=Reading+Table+2'),
(8,'item','https://placehold.co/800x600?text=iPhone+12+1'),(8,'item','https://placehold.co/800x600?text=iPhone+12+2'),
(9,'item','https://placehold.co/800x600?text=Generator+1'),(9,'item','https://placehold.co/800x600?text=Generator+2'),
(10,'item','https://placehold.co/800x600?text=Textbooks+1'),(10,'item','https://placehold.co/800x600?text=Textbooks+2'),
(11,'item','https://placehold.co/800x600?text=Office+Chair+1'),(11,'item','https://placehold.co/800x600?text=Office+Chair+2'),
(12,'item','https://placehold.co/800x600?text=Honda+Civic+1'),(12,'item','https://placehold.co/800x600?text=Honda+Civic+2'),
(13,'item','https://placehold.co/800x600?text=Microwave+1'),(13,'item','https://placehold.co/800x600?text=Microwave+2'),
(14,'item','https://placehold.co/800x600?text=Leather+Jacket+1'),(14,'item','https://placehold.co/800x600?text=Leather+Jacket+2'),
(15,'item','https://placehold.co/800x600?text=PlayStation+4+1'),(15,'item','https://placehold.co/800x600?text=PlayStation+4+2'),
(16,'item','https://placehold.co/800x600?text=Wardrobe+1'),(16,'item','https://placehold.co/800x600?text=Wardrobe+2'),
(1,'property','https://placehold.co/800x600?text=Lekki+Flat+1'),(1,'property','https://placehold.co/800x600?text=Lekki+Flat+2'),
(2,'property','https://placehold.co/800x600?text=Yaba+Self+Contain+1'),(2,'property','https://placehold.co/800x600?text=Yaba+Self+Contain+2'),
(3,'property','https://placehold.co/800x600?text=Maitama+Duplex+1'),(3,'property','https://placehold.co/800x600?text=Maitama+Duplex+2'),
(4,'property','https://placehold.co/800x600?text=Gwarinpa+Apartment+1'),(4,'property','https://placehold.co/800x600?text=Gwarinpa+Apartment+2'),
(5,'property','https://placehold.co/800x600?text=Surulere+Mini+Flat+1'),(5,'property','https://placehold.co/800x600?text=Surulere+Mini+Flat+2'),
(6,'property','https://placehold.co/800x600?text=Ikoyi+House+1'),(6,'property','https://placehold.co/800x600?text=Ikoyi+House+2'),
(7,'property','https://placehold.co/800x600?text=Wuse+Studio+1'),(7,'property','https://placehold.co/800x600?text=Wuse+Studio+2'),
(8,'property','https://placehold.co/800x600?text=Epe+Land+1'),(8,'property','https://placehold.co/800x600?text=Epe+Land+2'),
(9,'property','https://placehold.co/800x600?text=Kubwa+Bungalow+1'),(9,'property','https://placehold.co/800x600?text=Kubwa+Bungalow+2'),
(10,'property','https://placehold.co/800x600?text=Ikeja+Shop+1'),(10,'property','https://placehold.co/800x600?text=Ikeja+Shop+2'),
(11,'property','https://placehold.co/800x600?text=Lekki+Terrace+1'),(11,'property','https://placehold.co/800x600?text=Lekki+Terrace+2'),
(12,'property','https://placehold.co/800x600?text=Garki+Self+Contain+1'),(12,'property','https://placehold.co/800x600?text=Garki+Self+Contain+2');

INSERT INTO conversations (id, listing_id, listing_table, buyer_id, seller_id) VALUES
(1, 1, 'item', 11, 2),
(2, 3, 'item', 4, 5),
(3, 1, 'property', 9, 3),
(4, 7, 'property', 15, 14),
(5, 15, 'item', 10, 16);

INSERT INTO messages (conversation_id, sender_id, body, created_at) VALUES
(1, 11, 'Is this still available?', NOW() - INTERVAL '4 days'),
(1, 2, 'Yes, still available. Can you come see it this weekend?', NOW() - INTERVAL '4 days' + INTERVAL '15 minutes'),
(1, 11, 'Saturday afternoon works for me.', NOW() - INTERVAL '3 days'),
(2, 4, 'Can the dining set be delivered to Ajah?', NOW() - INTERVAL '2 days'),
(2, 5, 'Yes, delivery can be arranged for an extra fee.', NOW() - INTERVAL '2 days' + INTERVAL '20 minutes'),
(3, 9, 'Good day, can I inspect the Lekki flat tomorrow?', NOW() - INTERVAL '5 days'),
(3, 3, 'Yes, inspection is available from 11am.', NOW() - INTERVAL '5 days' + INTERVAL '25 minutes'),
(4, 15, 'Is the Wuse studio furnished as shown?', NOW() - INTERVAL '1 day'),
(4, 14, 'Yes, it comes furnished with the listed items.', NOW() - INTERVAL '1 day' + INTERVAL '12 minutes'),
(5, 10, 'Can you accept 90k for the PS4?', NOW() - INTERVAL '6 hours'),
(5, 16, 'I can do 95k if you pick up today.', NOW() - INTERVAL '5 hours');

INSERT INTO reports (listing_id, listing_table, reporter_id, reason, note, status) VALUES
(4, 'item', 11, 'Price seems misleading', 'The vehicle details need clearer mileage information.', 'pending'),
(10, 'property', 4, 'Duplicate or suspicious listing', 'The shop space address appears incomplete.', 'pending');

INSERT INTO featured_listings (listing_id, listing_table, user_id, amount, paystack_reference, featured_until) VALUES
(1, 'item', 2, 1500, 'feat_seed_001', NOW() + INTERVAL '5 days'),
(3, 'property', 6, 3000, 'feat_seed_002', NOW() + INTERVAL '6 days');

SELECT setval('users_id_seq', (SELECT MAX(id) FROM users));
SELECT setval('item_listings_id_seq', (SELECT MAX(id) FROM item_listings));
SELECT setval('property_listings_id_seq', (SELECT MAX(id) FROM property_listings));
SELECT setval('conversations_id_seq', (SELECT MAX(id) FROM conversations));
