import os
from flask import Flask, request, jsonify
import markdown
from langchain_groq import ChatGroq

app = Flask(__name__)

# Caricamento sicuro della API Key
GROQ_API_KEY = "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"                     

if not GROQ_API_KEY:
    raise ValueError("Errore: GROQ_API_KEY non trovata! Impostala nelle variabili d'ambiente.")

# Inizializzazione del modello LLM
llm = ChatGroq(model_name="llama3-8b-8192", temperature=0 , api_key=GROQ_API_KEY)

@app.route("/genera_dieta", methods=["GET"])
def genera_dieta():
    # Ottieni la query dalla richiesta HTTP
    query = request.args.get("query")
    
    if not query:
        return jsonify({"error": "Devi fornire una query"}), 400  # Errore 400 se manca la query

    # Genera la risposta dal modello
    response = llm.invoke(query)
    risposta = response.content


    marker = "**Ricordi importanti:**"
    if marker in risposta:
        risposta_tagliata = risposta.split(marker)[0]  # taglio da ricordi importanti in poi
    else:
        risposta_tagliata = markdown.markdown(risposta)  # Se il marker non esiste, usa tutto convertendolo in html

    # Converte il markdown in HTML
    risposta_html = markdown.markdown(risposta_tagliata)

   
    # Aggiungi il risultato alla struttura HTML con il CSS definito
    html_output = f"""
    <div class="form-section" >
        <h2 class="subtitle">Your personalized nutrition plan:</h2>
        <div class="description">{risposta_html}</div>
    </div>
    """
    return html_output

if __name__ == "__main__":
    app.run(debug=True)


