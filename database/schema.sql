CREATE TABLE IF NOT EXISTS users (
    id BIGSERIAL PRIMARY KEY,
    full_name VARCHAR(160) NOT NULL,
    email VARCHAR(180) NOT NULL UNIQUE,
    phone VARCHAR(40),
    password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(30) NOT NULL DEFAULT 'general' CHECK (role IN ('buyer_seller','landlord_tenant','general','admin')),
    is_verified BOOLEAN NOT NULL DEFAULT false,
    is_suspended BOOLEAN NOT NULL DEFAULT false,
    profile_picture_url TEXT,
    bio TEXT,
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS item_listings (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    title VARCHAR(180) NOT NULL,
    description TEXT NOT NULL,
    category VARCHAR(40) NOT NULL CHECK (category IN ('Electronics','Furniture','Vehicles','Fashion','Appliances','Books','Other')),
    condition VARCHAR(20) NOT NULL CHECK (condition IN ('new','like-new','used','fair')),
    price NUMERIC(14,2) NOT NULL CHECK (price >= 0),
    quantity INTEGER NOT NULL DEFAULT 1 CHECK (quantity >= 0),
    city VARCHAR(90),
    state VARCHAR(90),
    status VARCHAR(20) NOT NULL DEFAULT 'pending' CHECK (status IN ('pending','active','sold','removed','rejected')),
    rejection_reason TEXT,
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

ALTER TABLE item_listings ADD COLUMN IF NOT EXISTS city VARCHAR(90);
ALTER TABLE item_listings ADD COLUMN IF NOT EXISTS state VARCHAR(90);

CREATE TABLE IF NOT EXISTS property_listings (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    title VARCHAR(180) NOT NULL,
    description TEXT NOT NULL,
    listing_type VARCHAR(10) NOT NULL CHECK (listing_type IN ('rent','sale')),
    property_type VARCHAR(30) NOT NULL CHECK (property_type IN ('apartment','house','duplex','self-contain','land','commercial')),
    price NUMERIC(14,2) NOT NULL CHECK (price >= 0),
    rent_period VARCHAR(20) CHECK (rent_period IN ('monthly','yearly') OR rent_period IS NULL),
    bedrooms INTEGER DEFAULT 0 CHECK (bedrooms >= 0),
    bathrooms INTEGER DEFAULT 0 CHECK (bathrooms >= 0),
    size_sqft INTEGER DEFAULT 0 CHECK (size_sqft >= 0),
    address TEXT NOT NULL,
    city VARCHAR(90) NOT NULL,
    state VARCHAR(90) NOT NULL,
    amenities JSONB NOT NULL DEFAULT '[]'::jsonb,
    status VARCHAR(20) NOT NULL DEFAULT 'pending' CHECK (status IN ('pending','active','rented','sold','removed','rejected')),
    rejection_reason TEXT,
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS listing_images (
    id BIGSERIAL PRIMARY KEY,
    listing_id BIGINT NOT NULL,
    listing_table VARCHAR(10) NOT NULL CHECK (listing_table IN ('item','property')),
    image_url TEXT NOT NULL,
    uploaded_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS conversations (
    id BIGSERIAL PRIMARY KEY,
    listing_id BIGINT NOT NULL,
    listing_table VARCHAR(10) NOT NULL CHECK (listing_table IN ('item','property')),
    buyer_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    seller_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW(),
    UNIQUE (listing_id, listing_table, buyer_id, seller_id)
);

CREATE TABLE IF NOT EXISTS messages (
    id BIGSERIAL PRIMARY KEY,
    conversation_id BIGINT NOT NULL REFERENCES conversations(id) ON DELETE CASCADE,
    sender_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    body TEXT NOT NULL,
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW(),
    read_at TIMESTAMPTZ
);

CREATE TABLE IF NOT EXISTS reports (
    id BIGSERIAL PRIMARY KEY,
    listing_id BIGINT NOT NULL,
    listing_table VARCHAR(10) NOT NULL CHECK (listing_table IN ('item','property')),
    reporter_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    reason VARCHAR(140) NOT NULL,
    note TEXT,
    status VARCHAR(20) NOT NULL DEFAULT 'pending' CHECK (status IN ('pending','dismissed','removed')),
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS password_resets (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    token VARCHAR(128) NOT NULL UNIQUE,
    expires_at TIMESTAMPTZ NOT NULL,
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS email_verifications (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    token VARCHAR(128) NOT NULL UNIQUE,
    expires_at TIMESTAMPTZ NOT NULL,
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS featured_listings (
    id BIGSERIAL PRIMARY KEY,
    listing_id BIGINT NOT NULL,
    listing_table VARCHAR(10) NOT NULL CHECK (listing_table IN ('item','property')),
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    amount NUMERIC(14,2) NOT NULL CHECK (amount >= 0),
    paystack_reference VARCHAR(120) NOT NULL UNIQUE,
    featured_until TIMESTAMPTZ NOT NULL,
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE INDEX IF NOT EXISTS idx_users_email ON users(email);
CREATE INDEX IF NOT EXISTS idx_items_user ON item_listings(user_id);
CREATE INDEX IF NOT EXISTS idx_items_status ON item_listings(status);
CREATE INDEX IF NOT EXISTS idx_items_filters ON item_listings(category, condition, price);
CREATE INDEX IF NOT EXISTS idx_properties_user ON property_listings(user_id);
CREATE INDEX IF NOT EXISTS idx_properties_status ON property_listings(status);
CREATE INDEX IF NOT EXISTS idx_properties_filters ON property_listings(listing_type, property_type, city, state, price);
CREATE INDEX IF NOT EXISTS idx_images_listing ON listing_images(listing_table, listing_id);
CREATE INDEX IF NOT EXISTS idx_conversations_users ON conversations(buyer_id, seller_id);
CREATE INDEX IF NOT EXISTS idx_messages_conversation ON messages(conversation_id, created_at);
CREATE INDEX IF NOT EXISTS idx_reports_status ON reports(status);
CREATE INDEX IF NOT EXISTS idx_featured_active ON featured_listings(listing_table, listing_id, featured_until);
