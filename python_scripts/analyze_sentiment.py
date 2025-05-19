import sys
from textblob import TextBlob

def analyze_sentiment(review_text):
    # Perform sentiment analysis using TextBlob
    blob = TextBlob(review_text)
    polarity = blob.sentiment.polarity  # Sentiment score (-1 to 1)
    
    # Define thresholds for neutral sentiment
    neutral_threshold = 0.1  # Adjust this for sensitivity

    # Determine sentiment label based on polarity
    if polarity > neutral_threshold:
        sentiment = "Positive"
    elif polarity < -neutral_threshold:
        sentiment = "Negative"
    else:
        sentiment = "Neutral"
    
    return sentiment

if __name__ == "__main__":
    # Check if input is provided
    if len(sys.argv) < 2:
        print("Error: Please provide a review as a command-line argument.")
        sys.exit(1)
    
    # Get review text from command-line arguments
    review_text = sys.argv[1]
    
    # Analyze sentiment
    sentiment = analyze_sentiment(review_text)
    
    # Print the result
    print(sentiment)
