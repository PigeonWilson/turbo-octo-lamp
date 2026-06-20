import json
from pathlib import Path


def load_json_file(json_file_path):
    content = json_file_path.read_text(encoding="utf-8")
    data = json.loads(content)

    return data


script_directory = Path(__file__).parent
json_file_path = script_directory / "example.json"

if not json_file_path.exists():
    print("JSON file not found:", json_file_path)
else:
    data = load_json_file(json_file_path)

    print("Name:", data["name"])
    print("City:", data["city"])
    print("Category:", data["category"])
